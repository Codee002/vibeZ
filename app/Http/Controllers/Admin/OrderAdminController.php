<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\HandleOrderRequest;
use App\Models\Order;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\MessageBag;

class OrderAdminController extends Controller
{
    public function index(Request $request)
    {
        // dd($request->all());
        $data = $data = Order::query()->with('user', 'payment_method', 'delivery_info', 'discounts', 'order_details');

        if ($request['id']) {
            $data = $data->where('id', 'like', "%" . $request['id'] . "%");
        }

        if ($request['status']) {
            $data = $data->where('status',  $request['status'] );
        }

        if ($request['name']) {
            $data = $data->whereHas('user', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request['name'] . '%');
            });
        }

        $data = $data->orderBy("created_at", $request['created_at'] ?? "desc");

        $data = $data->paginate(8);
       
        return view("admin.order.index", [
            "data"        => $data,
            "status"        => $request['status'] ?? "",
            "name"        => $request['name'] ?? "",
            "id"          => $request['id'] ?? "",
            "order_by" => $request['created_at'] ?? "",
        ]);
    }

    public function show(Order $order)
    {
        $priceDelivery = 30;
        $order         = $order->load(['user', 'payment_method', 'delivery_info', 'discounts', 'order_details']);
        return view("admin.order.show", compact('order', 'priceDelivery'));

    }

    public function accept(Order $order)
    {
        if ($order['status'] != "pending")
        {
            return redirect()->back()->with("danger", "Đơn hàng đã được duyệt");
        }
        $order         = $order->load(['user', 'payment_method', 'delivery_info', 'discounts', 'order_details']);
        $orderProducts = $order->getOrderProducts();
        $warehouses    = Warehouse::with('warehouse_details')
            ->get()
            ->all();

        return view("admin.order.accept", compact('order', 'orderProducts', 'warehouses'));
    }

    public function handleOrder(HandleOrderRequest $request, Order $order)
    {
        $errors = new MessageBag();
        $check  = 1;
        $data   = $request->quantity;

        // Kiểm tra xem đã lên đơn cho tất cả sản phẩm chưa
        $checkProduct = 0;
        foreach ($order->order_details as $detail) {
            foreach ($request->quantity as $productId => $sizes) {
                if ($detail['product_id'] == $productId) {
                    foreach ($sizes as $size => $quantity) {
                        if ($detail['size'] == $size) {
                            $checkProduct++;
                        }
                    }
                }
            }
        }
        if ($checkProduct != count($order->order_details)) {
            $errors->add("required", "Chưa duyệt hết sản phẩm!");
            $check = 0;
        }

        foreach ($data as $productId => $sizes) {
            foreach ($sizes as $size => $warehouseIds) {
                $tempQuantity = 0;
                foreach ($warehouseIds as $warehouseId => $quantity) {

                    $warehouse           = Warehouse::find($warehouseId);
                    $quantityInWarehouse = $warehouse->getProductActiveQuantity($productId, $size);

                    // Kiểm tra SL kho
                    if ($quantityInWarehouse < $quantity) {
                        $productTemp = Product::find($productId);
                        $errors->add("warehouse_quantity_" . $productId . "_" . $size, "Số lượng hiện tại đang kích hoạt của sản phẩm " .
                            $productTemp['name'] . " size " . $size . " trong kho " . $warehouse['address'] . " không đủ");
                        $check = 0;
                    }

                    // Kiểm tra SL xuất ra của từng kho của đơn hàng
                    $tempQuantity += $quantity;

                }
                // Kiểm tra SL xuất ra của từng kho của đơn hàng
                if ($tempQuantity != $order->getQuantityProduct($productId, $size)) {
                    $productTemp = Product::find($productId);
                    $errors->add("quantity_" . $productId . "_" . $size, "Số lượng duyệt đơn cho sản phẩm " .
                        $productTemp['name'] . " size " . $size . " không hợp lệ");
                    $check = 0;
                }
            }
        }

        // Nếu có lỗi thì trả về lỗi
        if ($check == 0) {
            return redirect()->back()->withErrors($errors);
        }

        // Cập nhật
        try {
            DB::transaction(function () use ($data, $order) {
                foreach ($data as $productId => $sizes) {
                    foreach ($sizes as $size => $warehouseIds) {
                        // Cập nhật số lượng của từng kho nếu có
                        foreach ($warehouseIds as $warehouseId => $quantity) {
                            $warehouse = Warehouse::with('warehouse_details')->find($warehouseId);

                            // Cập nhật số lượng của kho
                            foreach ($warehouse->warehouse_details as $detail) {
                                if ($detail['product_id'] == $productId && $detail['size'] == $size) {
                                    $detail->update([
                                        'quantity' => $detail['quantity'] - $quantity,
                                    ]);
                                }
                            }
                        }

                    }
                }

                $order->update(['status' => 'shipping']);
            });
            return redirect()->route("admin.order.show", $order)->with("success", "Duyệt đơn thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }

    }

    public function reject(Order $order)
    {
        // dd($order['payment_method_id'] == 3);
        if ($order['payment_method_id'] == 3)
        {
            return redirect()->back()->with("danger", "Không thể hủy đơn hàng đã thanh toán!");
        }
        try {
            DB::transaction(function () use ($order) {
                $order->update([
                    "status" => 'rejecting',
                ]);
            });
            return redirect()->back()->with("success", "Hủy đơn thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }
}
