<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\CartDetail;
use App\Models\DeliveryInfo;
use App\Models\Discount;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\PaymentMethod;
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
            $cartId           = $user->cart['id'];
             $cartDetails[] = CartDetail::query()->create([
                "cart_id"    => $cartId,
                'product_id' => $request["product_id"],
                'size'       => $request["size"],
                'quantity'   => $request["quantity"],
            ]);
            // dd( $cartDetails);
            // Lấy giá cho sản phẩm
             $cartDetails[0]['price'] = SalePrice::getPriceBySize( $cartDetails[0]['product_id'],  $cartDetails[0]['size']);

            // Giá SP
             $cartDetails[0]['totalPrice'] =  $cartDetails[0]['price'] *  $cartDetails[0]['quantity'];

            // Lấy ra tổng giá của đơn hàng
            $totalPriceProduct +=  $cartDetails[0]['totalPrice'];

            // Lấy DS Khuyến mãi theo danh mục
            foreach ($discountsTemp as $discount) {
                if ($discount['category_id'] ==  $cartDetails[0]->product['category_id']
                    && ! in_array($discount, $discounts)) {
                    $discounts[] = $discount;
                }
            }
            $cartDetails[0]->delete();
        }

        // Lấy ra giá khuyến mãi theo cấp
        $priceRankDiscount = $totalPriceProduct * $user->getRankDiscount() / 100;

        return view("pages.components.order_detail", [
            "cartDetails"       =>  $cartDetails,
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

                $order = Order::query()->create($data);

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
            return redirect()->route("cart")->with("success", "Đặt hàng thành công");
        } catch (\Throwable $th) {
            return redirect()->route("cart")->with("danger", $th->getMessage())->withInput();
            // return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    public function history(Request $request)
    {
        $search = $request->query("search");
        $user   = Auth::user();
        $data   = collect();
        if ($search) {
            $data = Order::query()
                ->where('name', 'like', "%" . $search . "%")
                ->orderBy('created_at', "desc")
                ->with('user', 'payment_method', 'delivery_info', 'discounts', 'order_details', 'evaluates')
                ->paginate(5);
            return view("admin.order.index", ['data' => $data, 'search' => $search]);
        } else {
            $data = Order::with('user', 'payment_method', 'delivery_info', 'discounts', 'order_details', 'evaluates')
                ->orderBy('created_at', "desc")
                ->where("user_id", $user['id'])
                ->paginate(5);
        }
        return view("pages.components.order_history", compact("data"));
    }

    public function detail(Order $order)
    {
        $priceDelivery = 30;
        $order         = $order->load(['user', 'payment_method', 'delivery_info', 'discounts', 'order_details', 'evaluates']);
        return view("pages.components.order_history_detail", compact("order", 'priceDelivery'));
    }

    public function abort(Order $order)
    {
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
