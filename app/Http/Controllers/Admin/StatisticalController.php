<?php
namespace App\Http\Controllers\Admin;

use App\Exports\StatisticalExport;
use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\SalePrice;
use App\Models\Size;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class StatisticalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all(), $request['null']);
        $products = Product::getAllProduct(8, $request['name'], $request['category'], $request['price'], $request['id']);

        foreach ($products as $product) {
            $product['image'] = Image::getImage($product['product_id']);
            $product['sizes'] = Size::getSizeInWarehouse($product['product_id']);

            // Số lượng
            $quantityWarehouse = 0;
            $quantityOrder     = 0;
            $quantityShip      = 0;

            // Giá
            $purchasePrice = Receipt::getPurchasePrice($product['product_id']);
            $salePrice     = 0;
            $countSale     = 0;
            foreach ($product['sizes'] as $size) {
                // Lấy tổng SL sản phẩm của tổng các kho (tính chung trạng thái)
                $quantityWarehouse += WarehouseDetail::getQuantity($product['product_id'], $size);
                $quantityOrder += Order::getAllProductCompletingQuantity($product['product_id'], $size);
                $quantityShip += Order::getAllProductShippingQuantity($product['product_id'], $size);

                // Gía bán
                $salePrice += Order::getAllPriceCompleting($product['product_id'], $size);
                $countSale += Order::getAllQuantityCompleting($product['product_id'], $size);

            }
            // Số lượng của SP
            $product['quantity_warehouse'] = $quantityWarehouse;
            $product['quantity_order']     = $quantityOrder;
            $product['quantity_ship']      = $quantityShip;
            $product['quantity_receipt']   = $quantityOrder + $quantityWarehouse + $quantityShip;

            // Xử lý giá
            if ($salePrice == 0) {
                $salePrice = SalePrice::query()->where("product_id", $product['product_id'])->first()->price;
            } else {
                $salePrice = $salePrice / $countSale;
            }

            if ($product['product_id'] == 25) {
                // dd(Order::getAllPriceCompleting(25, 41),$countSale,  count($product['sizes']));
            }

            // Giá bán
            $purchasePrice = $purchasePrice / $product['quantity_receipt'];

            // Giá của SP
            $product['purchase_price'] = $purchasePrice;
            $product['sale_price']     = $salePrice;

        }
        // dd($products->all(), $purchasePrice, Receipt::getQuantityProduct($product['product_id']));

        if ($request['quantity_receipt'] == "asc") {
            $sorted = $products->sortBy('purchase_price');
        } else {
            $sorted = $products->sortByDesc('purchase_price');
        }

        return view("admin.statistical.index", [
            "products" => $products,
            "name"     => $request['name'] ?? null,
            "id"       => $request['id'] ?? null,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function revenue(Request $request)
    {
        if (! empty($request->all())) {
            if (! empty($request['end_at']) && $request['start_at'] > $request['end_at']) {
                return redirect()->back()->with("danger", "Ngày bắt đầu không được lớn hơn ngày kết thúc")->withInput();
            }
        }
        // Tổng giá
        $totalPurchasePrice = Receipt::getTotalPriceCompleted($request['start_at'] ?? "", $request['end_at'] ?? "");
        $totalSalePrice     = Order::getTotalPriceCompleted($request['start_at'] ?? "", $request['end_at'] ?? "");

        // Tổng số lượng
        $totalQuantityReceipt   = Receipt::getTotalQuantityCompleted($request['start_at'] ?? "", $request['end_at'] ?? "");
        $totalQuantityOrder     = Order::getTotalQuantityCompleted($request['start_at'] ?? "", $request['end_at'] ?? "");
        $totalQuantityShipping  = Order::getTotalQuantityShipping($request['start_at'] ?? "", $request['end_at'] ?? "");
        $totalQuantityWarehouse = Warehouse::getAllQuantity();

        return view("admin.statistical.revenue", [
            "totalPurchasePrice"     => $totalPurchasePrice,
            "totalSalePrice"         => $totalSalePrice,
            "totalQuantityReceipt"   => $totalQuantityReceipt,
            "totalQuantityOrder"     => $totalQuantityOrder,
            "totalQuantityShipping"  => $totalQuantityShipping,
            "totalQuantityWarehouse" => $totalQuantityWarehouse,
            "startDate"              => $request['start_at'] ?? null,
            "endDate"                => $request['end_at'] ?? null,
        ]);
    }

    public function export(Request $request)
    {
// dd($request->all(), $request['null']);
        $products = Product::getAllProduct(null, $request['search'], $request['category']);

        foreach ($products as $product) {
            $product['image'] = Image::getImage($product['product_id']);
            $product['sizes'] = Size::getSizeInWarehouse($product['product_id']);

            // Số lượng
            $quantityWarehouse = 0;
            $quantityOrder     = 0;
            $quantityShip      = 0;

            // Giá
            $purchasePrice = Receipt::getPurchasePrice($product['product_id']);
            $salePrice     = 0;
            $countSale     = 0;
            foreach ($product['sizes'] as $size) {
                // Lấy tổng SL sản phẩm của tổng các kho (tính chung trạng thái)
                $quantityWarehouse += WarehouseDetail::getQuantity($product['product_id'], $size);
                $quantityOrder += Order::getAllProductCompletingQuantity($product['product_id'], $size);
                $quantityShip += Order::getAllProductShippingQuantity($product['product_id'], $size);

                // Gía bán
                $salePrice += Order::getAllPriceCompleting($product['product_id'], $size);
                $countSale += Order::getAllQuantityCompleting($product['product_id'], $size);

            }
            // Số lượng của SP
            $product['quantity_warehouse'] = $quantityWarehouse;
            $product['quantity_order']     = $quantityOrder;
            $product['quantity_ship']      = $quantityShip;
            $product['quantity_receipt']   = $quantityOrder + $quantityWarehouse + $quantityShip;

            // Xử lý giá
            if ($salePrice == 0) {
                $salePrice = SalePrice::query()->where("product_id", $product['product_id'])->first()->price;
            } else {
                $salePrice = $salePrice / $countSale;
            }

            if ($product['product_id'] == 25) {
                // dd(Order::getAllPriceCompleting(25, 41),$countSale,  count($product['sizes']));
            }

            // Giá bán
            $purchasePrice = $purchasePrice / $product['quantity_receipt'];

            // Giá của SP
            $product['purchase_price'] = $purchasePrice;
            $product['sale_price']     = $salePrice;
        }
        // dd($products, Carbon::now()->format("d/m/Y"));
        $name = "ThongKeSanPham_" . Carbon::now()->format("d_m_Y") . ".xlsx";
        return Excel::download(new StatisticalExport($products), $name);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }
}
