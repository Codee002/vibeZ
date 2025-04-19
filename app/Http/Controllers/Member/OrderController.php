<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CartDetail;
use App\Models\DeliveryInfo;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
use App\Models\Rank;
use App\Models\SalePrice;
use App\Models\WarehouseDetail;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function order(Request $request)
    {
        // dd($request->all());
        /**
         * @var User $user
         */
        $user = Auth::user();
        // dd($request, $request['cartDetailId']);
        $totalPriceProduct = 0;
        $priceDelivery     = 30;
        $pricePromotion    = 0;
        $priceRankDiscount = 0;

        // Lấy ra thông tin nhận hàng
        $deliveryInfos = DeliveryInfo::query()
            ->where("user_id", (Auth::id()))
            ->get();

        // Thông tin nhận mặc định
        $deliveryDefault = null;
        foreach ($deliveryInfos as $delivery) {
            if ($delivery['default'] == 1) {
                $deliveryDefault = $delivery;
            }
        }

        // Lấy phương thức thanh toán
        $payMenthods = PaymentMethod::query()->get();

        // Lấy DS Khuyến mãi
        $discountsTemp = Discount::getActivedDiscounts(Carbon::now());
        $discounts     = [];

        $cartDetails = [];
        // Kiểm tra hình thức đặt hàng
        if ($request['type'] == "cart") {
            foreach ($request['cartDetailId'] as $i => $id) {
                // Lấy SP từ chi tiết giỏ hàng
                $cartDetails[] = CartDetail::query()
                    ->find($id)->load(['product', 'size']);

                // Lấy giá cho sản phẩm
                $cartDetails[$i]['price'] = SalePrice::getPriceBySize($cartDetails[$i]['product_id'], $cartDetails[$i]['size']);

                // Lấy danh mục sản phẩm
                // $cartDetails[$i]['category'] = $cartDetails[$i]->product['category_id'];

                // Giá SP
                $cartDetails[$i]['totalPrice'] = $cartDetails[$i]['price'] * $cartDetails[$i]['quantity'];

                // Lấy ra tổng giá của đơn hàng
                $totalPriceProduct += $cartDetails[$i]['totalPrice'];

                // Lấy DS Khuyến mãi theo danh mục
                foreach ($discountsTemp as $discount) {
                    if ($discount['category_id'] == $cartDetails[$i]->product['category_id']
                        && ! in_array($discount, $discounts)) {
                        $discounts[] = $discount;
                    }
                }
            }
        } else if ($request['type'] == "detail") {
            // Tạo riêng 1 SP đó trong giỏ hàng
            $cartId        = $user->cart['id'];
            $cartDetails[] = CartDetail::query()->create([
                "cart_id"    => $cartId,
                'product_id' => $request["product_id"],
                'size'       => $request["size"],
                'quantity'   => $request["quantity"],
            ]);
            // dd( $cartDetails);
            // Lấy giá cho sản phẩm
            $cartDetails[0]['price'] = SalePrice::getPriceBySize($cartDetails[0]['product_id'], $cartDetails[0]['size']);

            // Giá SP
            $cartDetails[0]['totalPrice'] = $cartDetails[0]['price'] * $cartDetails[0]['quantity'];

            // Lấy ra tổng giá của đơn hàng
            $totalPriceProduct += $cartDetails[0]['totalPrice'];

            // Lấy DS Khuyến mãi theo danh mục
            foreach ($discountsTemp as $discount) {
                if ($discount['category_id'] == $cartDetails[0]->product['category_id']
                    && ! in_array($discount, $discounts)) {
                    $discounts[] = $discount;
                }
            }
            $cartDetails[0]->delete();
        }

        // Lấy ra giá khuyến mãi theo cấp
        $priceRankDiscount = $totalPriceProduct * $user->getRankDiscount() / 100;

        return view("pages.components.order_detail", [
            "cartDetails"       => $cartDetails,
            "cartIds"           => $request['cartDetailId'],
            "type"              => $request['type'],
            "totalPriceProduct" => $totalPriceProduct,
            "priceDelivery"     => $priceDelivery,
            "pricePromotion"    => $pricePromotion,
            "priceRankDiscount" => $priceRankDiscount,
            "deliveryInfos"     => $deliveryInfos,
            "deliveryDefault"   => $deliveryDefault,
            "payMenthods"       => $payMenthods,
            "discounts"         => $discounts,
        ]);
    }

    public function store(Request $request)
    {
        // Kiểm tra SL trước khi đặt
        for ($i = 0; $i < count($request->products); $i++) {
            // Lấy ra tổng SL của SP trong tổng kho đang kích hoạt
            $quantityCheck = WarehouseDetail::getQuantityActive($request['products'][$i], $request['sizes'][$i]);

            // Lấy ra tổng SL sản phẩm đang được chờ duyệt đơn
            $pendingQuantitie = Order::getAllProductPendingQuantity($request['products'][$i], $request['sizes'][$i]);

            // dd($request->all(), $quantityCheck, $pendingQuantitie, $request['quantities'][$i]);
            if ($request['quantities'][$i] > ($quantityCheck - $pendingQuantitie)) {
                return redirect()->route("order.history")->with("danger", "Số lượng đặt nhiều hơn số lượng đang có của cửa hàng hiện tại!");
            }
        }

        // Thanh toán VNPay
        if ($request['payMethod'] == 3) {
            $request['vnpay'] = 1;

            // Tạo mã đơn hàng
            $lastOrder           = Order::orderBy("id", "desc")->first();
            $request['order_id'] = $lastOrder['id'] + 1;
            return $this->vnpay($request);
        }

        // Thanh toán trực tiếp
        return $this->createOrder($request);
    }

    public function createOrder($request)
    {
        $user = Auth::user();
        try {
            DB::transaction(function () use ($request, $user) {
                $data = [
                    "user_id"           => $user['id'],
                    "delivery_info_id"  => $request['delivery'],
                    "payment_method_id" => $request['payMethod'],
                    "status"            => 'pending',
                    "total_price"       => $request['total_price'],
                    "rank_discount"     => $request['rank_discount'],
                ];

                if ($request['order_id']) {
                    $data['id'] = $request['order_id'];
                }

                $order = Order::query()->create($data);
                session()->flash("newOrder", $order);

                for ($i = 0; $i < count($request['products']); $i++) {
                    OrderDetail::query()
                        ->create([
                            'order_id'   => $order['id'],
                            'product_id' => $request['products'][$i],
                            'size'       => $request['sizes'][$i],
                            'quantity'   => $request['quantities'][$i],
                            'price'      => $request['prices'][$i],
                        ]);
                }

                if (isset($request['discounts'])) {
                    $order->discounts()->attach($request['discounts']);
                }

                // Nếu đặt qua giỏ hàng thì xóa khỏi giỏ
                if ($request['type'] == "cart") {
                    foreach ($request['cartDetailId'] as $cartId) {
                        CartDetail::find($cartId)->delete();
                    }
                }
            });
            return redirect()->route("order.history.detail", session("newOrder"))->with("success", "Đặt hàng thành công");
        } catch (\Throwable $th) {
            return redirect()->route("order.history")->with("danger", $th->getMessage())->withInput();
            // return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    // Thanh toán VNPAY
    public function vnpay(Request $request)
    {
        // dd("vnpay", $request->all());
        $vnp_Url        = env('VNPAY_URL');
        $vnp_Returnurl  = env('VNPAY_RETURN_URL');
        $vnp_TmnCode    = env('VNPAY_TMNCODE');    //Mã website tại VNPAY
        $vnp_HashSecret = env('VNPAY_HASHSECRET'); //Chuỗi bí mật

        $vnp_TxnRef    = "HD" . $request['order_id']; //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
        $vnp_OrderType = "billpayment";
        $vnp_Amount    = $request['total_price'] * 1000 * 100;
        $vnp_OrderInfo = "Thanh toan cho don hang so tien " . $vnp_Amount . "Đ";
        $vnp_Locale    = "vn";
        // $vnp_BankCode  = "NCB";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        //Add Params of 2.0.1 Version

        $inputData = [
            "vnp_Version"    => "2.1.0",
            "vnp_TmnCode"    => $vnp_TmnCode,
            "vnp_Amount"     => $vnp_Amount,
            "vnp_Command"    => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode"   => "VND",
            "vnp_IpAddr"     => $vnp_IpAddr,
            "vnp_Locale"     => $vnp_Locale,
            "vnp_OrderInfo"  => $vnp_OrderInfo,
            "vnp_OrderType"  => $vnp_OrderType,
            "vnp_ReturnUrl"  => $vnp_Returnurl,
            "vnp_TxnRef"     => $vnp_TxnRef,
            // "vnp_ExpireDate" => $vnp_ExpireDate,
        ];

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
            $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        //var_dump($inputData);
        ksort($inputData);
        $query    = "";
        $i        = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret); //
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }
        $returnData = [
            'code'    => '00',
            'message' => 'success',
            'data'    => $vnp_Url,
        ];
        if (isset($request['vnpay'])) {
            // header('Location: ' . $vnp_Url);
            session()->flash('order', $request->all());
            return redirect()->to($vnp_Url);
            die();
        } else {
            echo json_encode($returnData);
        }
    }

    public function handle_vnpay(Request $request)
    {
        $orderTemp = session("order");
        // dd($request->all(), $orderTemp, $request['vnp_ResponseCode']);
        if ($request['vnp_ResponseCode'] != "00") {
            return redirect()->route("order.history")->with("danger", "Thanh toán thất bại!");
        }

        return $this->createOrder($orderTemp);
    }

    public function history(Request $request)
    {
        /**
         * @var User $user
         */
        $user   = Auth::user();
        $search = $request->query("search");
        $data   = collect();

        // Lấy ra rank của user
        $user['rank']        = $user->getRank();
        $user['order_price'] = $user->getOrderPriceCompleted();
        $ranks               = Rank::get()->all();
        foreach ($ranks as $rank) {
            if ($user['rank'] == $rank['type']) {
                $user['discount'] = $rank['discount'];
            }
        }

        if ($search) {
            $data = Order::query()
                ->where('name', 'like', "%" . $search . "%")
                ->orderBy('created_at', "desc")
                ->with('user', 'payment_method', 'delivery_info', 'discounts', 'order_details', 'evaluates')
                ->paginate(8);
            return view("admin.order.index", ['data' => $data, 'search' => $search]);
        } else {
            $data = Order::with('user', 'payment_method', 'delivery_info', 'discounts', 'order_details', 'evaluates')
                ->orderBy('created_at', "desc")
                ->where("user_id", $user['id'])
                ->paginate(8);
        }
        return view("pages.components.order_history", compact("data", 'user'));
    }

    public function detail(Order $order)
    {
        /**
         * @var User $user
         */
        $user = Auth::user();
        if ($order['user_id'] != $user['id']) {
            abort(403);
        }

        $priceDelivery = 30;
        $order         = $order->load(['user', 'payment_method', 'delivery_info', 'discounts', 'order_details', 'evaluates']);
        return view("pages.components.order_history_detail", compact("order", 'priceDelivery'));
    }

    public function abort(Order $order)
    {
        if ($order['payment_method_id'] == 3) {
            return redirect()->back()->with("danger", "Không thể hủy đơn hàng đã thanh toán!");
        }

        try {
            DB::transaction(function () use ($order) {
                $order->update([
                    "status" => 'aborting',
                ]);
            });
            return redirect()->back()->with("success", "Hủy đơn thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    public function receive(Order $order)
    {
        try {
            DB::transaction(function () use ($order) {
                $order->update([
                    "status" => 'completing',
                ]);
            });
            return redirect()->back()->with("success", "Nhận đơn thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    // Xuất file
    public function printInvoice(Order $order)
    {
        $priceDelivery = 30;
        $order         = $order->load(['user', 'payment_method', 'delivery_info', 'discounts', 'order_details', 'evaluates']);

        $pdf = Pdf::loadView('admin.order.print', compact("order", "priceDelivery"));

        $pdf->setPaper('A4', 'portrait');

        return $pdf->stream('invoice.pdf');

        return view("admin.order.print", compact("order", 'priceDelivery'));
    }
}
