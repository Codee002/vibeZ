<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCartRequest;
use App\Models\Cart;
use App\Models\CartDetail;
use App\Models\Order;
use App\Models\WarehouseDetail;
use Illuminate\Http\Request;
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
        $cartDetails->load(['product', 'size']);
        // dd($cart, $cartDetails);
        return view('pages.components.cart', [
            'cart'        => $cart,
            'cartDetails' => $cartDetails,
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
            ->where('size', $request["size"])->first();

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
    public function updateQuantity(Request $request, $quantity)
    {
        dd($request, $quantity);
    }

    // Xóa sản phẩm khỏi giỏ hàng
    public function deleteCart($cartDetailId)
    {
        CartDetail::find($cartDetailId)->delete();
        return redirect()->back()->with("success", "Xóa sản phẩm khỏi giỏ hàng thành công");
    }

}
