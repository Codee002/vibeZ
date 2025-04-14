<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\Size;
use App\Models\WarehouseDetail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{

    // Hiển thị giỏ hàng
    public function showCart()
    {
        $user        = Auth::user();
        $cart        = $user->cart;
        $cartDetails = $cart->cart_details()
            ->orderBy("updated_at", "DESC")
            ->get();
        // $cartDetails->load(['product', 'size']);

        // Lấy ra các size và số lượng từng size của sản phẩm
        $quantities        = [];
        $pendingQuantities = [];
        foreach ($cartDetails as $detail) {
            $detail['sizes'] = Size::getSizeActiveInWarehouse($detail['product_id']);

            foreach ($detail['sizes'] as $size) {
                // Lấy tổng SL sản phẩm của tổng các kho đang được kích hoạt
                $quantities[$detail['product_id']][$size] = WarehouseDetail::getQuantityActive($detail['product_id'], $size);

                // Lấy ra tổng SL sản phẩm đang được chờ duyệt đơn
                $pendingQuantities[$detail['product_id']][$size] = Order::getAllProductPendingQuantity($detail['product_id'], $size);
            }

            // dd( $detail, $quantities, $pendingQuantities);
        }
        return view('pages.components.cart', [
            'cart'              => $cart,
            'cartDetails'       => $cartDetails,
            'quantities'        => $quantities,
            'pendingQuantities' => $pendingQuantities,
        ]);
    }

    // Lưu sản phẩm vào giỏ hàng
    public function addToCart(StoreCartRequest $request)
    {
        $user   = Auth::user();
        $cartId = $user->cart['id'];

        // Kiểm tra số lượng kho
        $cartDetail = CartDetail::query()
            ->where('product_id', $request["product_id"])
            ->where('size', $request["size"])
            ->where('cart_id', $cartId)
            ->first();

        // Lấy ra tổng SL của SP trong tổng kho đang kích hoạt
        $quantityCheck = WarehouseDetail::getQuantityActive($request['product_id'], $request['size']);

        // Lấy ra tổng SL sản phẩm đang được chờ duyệt đơn
        $pendingQuantitie = Order::getAllProductPendingQuantity($request['product_id'], $request['size']);
        // $pendingQuantitie = 0;

        if ((($cartDetail['quantity'] ?? 0) + $request['quantity']) > ($quantityCheck - $pendingQuantitie)) {
            return back()->with("danger", "Số lượng thêm vào giỏ không được nhiều hơn số lượng hàng đang có");
        }

        try {
            DB::transaction(function () use ($request, $cartId, $cartDetail) {
                // Kiểm tra nếu chưa tồn tại thì thêm vào giỏ
                if (! $cartDetail) {
                    CartDetail::query()->create([
                        "cart_id"    => $cartId,
                        'product_id' => $request["product_id"],
                        'size'       => $request["size"],
                        'quantity'   => $request["quantity"],
                    ]);
                } else {
                    $cartDetail->update([
                        "quantity" => $cartDetail['quantity'] + $request["quantity"],
                    ]);
                }
            });
            return redirect()->back()->with("success", "Thêm sản phẩm vào giỏ hàng thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    // Thay đổi số lượng trong giỏ hàng
    public function updateQuantity(StoreCartRequest $request)
    {
        // dd($request->all());
        // Kiểm tra số lượng kho
        $user   = Auth::user();
        $cartId = $user->cart['id'];

                                          // Kiểm tra số lượng kho
        $cartDetail = CartDetail::query() // Lấy ra tất cả các SP có size tương ứng ở trong giỏ hàng của khách hàng đó
            ->where('product_id', $request["product_id"])
            ->where('size', $request["size"])
            ->where('cart_id', $cartId)
            ->first();

        // Lấy ra SP cần sửa hiện tại
        $currentDetail = CartDetail::find($request['cart_detail_id']);

        // Lấy ra số lượng đã có của sản phẩm với size đó trong giỏ hàng
        $quantityTemp = 0;
        // Nếu sản phẩm cần chỉnh sửa không là chính nó (có khả năng $cartDetail là chính $current trong trường hợp k thay đổi size)
        if ($cartDetail != $currentDetail) {
            $quantityTemp = $cartDetail['quantity'] ?? 0;
        }

        // dd($request->all(), $cartDetail, $currentDetail, $cartDetail != $currentDetail, $quantityTemp);
        // Lấy ra tổng SL của SP trong tổng kho đang kích hoạt
        $quantityCheck = WarehouseDetail::getQuantityActive($request['product_id'], $request['size']);

        // Lấy ra tổng SL sản phẩm đang được chờ duyệt đơn
        $pendingQuantitie = Order::getAllProductPendingQuantity($request['product_id'], $request['size']);
        // $pendingQuantitie = 0;

        if (($quantityTemp + $request['quantity']) > ($quantityCheck - $pendingQuantitie)) {
            return back()->with("danger", "Số lượng thêm vào giỏ không được nhiều hơn số lượng hàng đang có");
        }
        try {
            DB::transaction(function () use ($request, $cartDetail, $currentDetail) {
                // cartDetail là current (Trường hợp không đổi size)
                if ($currentDetail == $cartDetail) {
                    $currentDetail->update([
                        'size'     => $request["size"],
                        'quantity' => $request["quantity"],
                    ]);
                }
                // Trường hợp current thay đổi size
                else {
                    $currentDetail->update([
                        'size'     => $request["size"],
                        'quantity' => $request["quantity"] + ($cartDetail['quantity'] ?? 0),
                    ]);
                    if ($cartDetail) {
                        $cartDetail->delete();
                    }
                }
            });
            return redirect()->back()->with("success", "Chỉnh sửa số lượng sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCart($cartDetailId)
    {
        CartDetail::find($cartDetailId)->delete();
        return redirect()->back()->with("success", "Xóa sản phẩm khỏi giỏ hàng thành công");
    }

}
