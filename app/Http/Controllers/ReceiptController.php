<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreReceiptRequest;
use App\Models\Product;
use App\Models\Receipt;
use App\Models\ReceiptDetail;
use App\Models\SalePrice;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReceiptController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        $data   = collect();
        if ($search) {
            $data = Receipt::with(['warehouse', 'receipt_details'])
                ->where('status', 'like', "%" . $search . "%")
                ->paginate(3);
            return view("admin.product.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = Receipt::with(['warehouse', 'receipt_details'])->paginate(3);
        }
        return view("admin.receipt.index", compact('data'));
    }

    public function choiceProduct()
    {
        $data = Product::with(['category', 'sizes', 'images', 'warehouse_details'])->get();
        return view('admin.receipt.choiceProduct', compact('data'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        // dd($request->all());
        $addProducts  = $request->addProducts;
        $productSizes = $request->products;
        // dd($products);

        $products = [];

        // Tìm ra sản phẩm cần thêm
        foreach ($addProducts as $id) {
            if (! empty($productSizes[$id])) {
                $products[$id] = $productSizes[$id];
            }

        }
        //    dd($products);
        // Lúc này thì đã tạo mảng gửi dữ liệu sang được rồi, nhưng tránh
        // trường hợp N+1 Query nên tìm từng phần tử rồi load Relationship
        $data = [];
        foreach ($products as $id => $size) {
            $product = Product::with("images", 'sizes', 'category', 'receipt_details', 'sale_prices')
                ->find($id);
            $data[] = [
                'product' => $product,
                'sizes'   => $size,
            ];
        }

        $warehouses = Warehouse::query()->pluck("address", "id")->all();
        return view("admin.receipt.create", compact('data', 'warehouses'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreReceiptRequest $request)
    {
        // Lấy số lượng sản phẩm nhập
        $quantity = 0;
        foreach ($request->product as $productIds) {
            foreach ($productIds as $size) {
                $quantity += $size['quantity'];
            }
        }

        // Kiểm tra số lượng kho
        $warehouseId = $request->warehouse;
        $warehouse   = Warehouse::with(['warehouse_details'])->find($warehouseId);

        // Kiểm tra kho còn đủ để nhập
        if ($warehouse->getQuantity() + $quantity > $warehouse->capacity) {
            return redirect()->back()->with("danger", "Kho không còn đủ chổ trống!")->withInput();
        }

        try {
            DB::transaction(function () use ($request) {
                $receipt = Receipt::query()->create([
                    "warehouse_id" => $request->warehouse,
                ]);
                foreach ($request->product as $id => $productIds) {
                    foreach ($productIds as $size => $data) {
                        ReceiptDetail::query()->create([
                            'receipt_id'     => $receipt->id,
                            'product_id'     => $id,
                            'size'           => $size,
                            'quantity'       => $data['quantity'],
                            'purchase_price' => $data['purchase_price'],
                        ]);

                        WarehouseDetail::query()->create([
                            'quantity'     => $data['quantity'],
                            'size'         => $size,
                            'product_id'   => $id,
                            'warehouse_id' => $request->warehouse,
                        ]);

                        SalePrice::updateOrCreate(
                            [
                                'product_id' => $id,
                                'size'       => $size,
                            ],
                            [
                                'price'      => $data['sale_price'],
                                'quantity'   => $data['quantity'],
                            ]
                        );
                    }
                }
            });
            return redirect()->route("admin.receipt.index")->with("success", "Tạo phiếu nhập thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Receipt $receipt)
    {
        $receipt = $receipt->load(['warehouse', 'receipt_details']);
        return view("admin.receipt.show", compact('receipt'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view("admin.receipt.edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Kiểm tra ảnh trước khi xóa
        try {

            return redirect()->route("admin.product.index")->with("success", "Chỉnh sửa sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Receipt $receipt)
    {
        try {
            DB::transaction(function () use ($receipt) {
                $receipt->delete();
            });
            return redirect()->route("admin.receipt.index")->with("success", "Xóa phiếu nhập thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }
}
