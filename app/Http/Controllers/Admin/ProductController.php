<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Evaluate;
use App\Models\Image;
use App\Models\Order;
use App\Models\Product;
use App\Models\SalePrice;
use App\Models\Size;
use App\Models\WarehouseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $data = $data = Product::query();

        if ($request['id']) {
            $data = $data->where('id', 'like', "%" . $request['id'] . "%");
        }

        if ($request['name']) {
            $data = $data->where('name', 'like', "%" . $request['name'] . "%");
        }

        if ($request['category']) {
            $data = $data->where('category_id', 'like', "%" . $request['category'] . "%");
        }

        $data = $data->orderBy("id", $request['order_by'] ?? "desc");

        $data = $data->paginate(8);

        $categories = Category::get()->all();
        return view("admin.product.index", [
            "data"        => $data,
            "name"        => $request['name'] ?? "",
            "id"          => $request['id'] ?? "",
            "category_id" => $request['category'] ?? "",
            "order_by"    => $request['order_by'] ?? "",
            "categories"  => $categories,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->pluck("name", "id")->all();
        $sizes      = Size::query()->pluck("size", "size")->all();
        return view("admin.product.create", [
            'categories' => $categories,
            'sizes'      => $sizes,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        // dd($request->all());
        try {
            DB::transaction(function () use ($request) {
                $dataProduct = [
                    "name"        => $request->name,
                    "category_id" => $request->category,
                    "des"         => $request->des,
                ];

                $product = Product::query()->create($dataProduct);

                if ($request->has('images')) {
                    foreach ($request->images as $image) {
                        Image::query()->create([
                            "product_id" => $product->id,
                            "img_path"   => Storage::put("products", $image),
                        ]);
                    }
                }

                $product->sizes()->attach($request->sizes);

            });
            return redirect()->route("admin.product.index")->with("success", "Thêm sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        $product = $product->load(['category', 'images', 'sizes']);
        return view("admin.product.show", compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        $product      = $product->load(['category', 'images', 'sizes']);
        $productSizes = $product->sizes->pluck('size')->all();
        $categories   = Category::query()->pluck("name", "id")->all();
        $sizes        = Size::query()->pluck("size", "size")->all();
        return view("admin.product.edit", compact('product', 'categories', 'sizes', 'productSizes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        // Kiểm tra ảnh trước khi xóa
        if (! empty($request->deleteImages)) {
            if ($product->images->count() == count($request->deleteImages)) {
                return redirect()->route("admin.product.edit", $product)->with("danger", "Sản phẩm phải có ít nhất 1 hình ảnh");
            }
        }

        // Kiểm tra size trước khi chỉnh sửa
        foreach (Size::getSizeInWarehouse($product['id']) as $size) {
            if (! in_array($size, $request['sizes'])) {
                return redirect()->back()->with("danger", "Kích thước $size không thể xóa do đã nhập về kho!")->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request, $product) {
                $dataProduct = [
                    "name"        => $request->name,
                    "category_id" => $request->category,
                    "des"         => $request->des,
                ];

                $product->update($dataProduct);
                $product->sizes()->sync($request->sizes);

                // Thêm ảnh
                if ($request->has('addImages')) {
                    foreach ($request->addImages as $image) {
                        Image::query()->create([
                            "product_id" => $product->id,
                            "img_path"   => Storage::put("products", $image),
                        ]);
                    }
                }

                // Sửa ảnh
                if ($request->has('images')) {
                    foreach ($request->images as $id => $image) {
                        $img = Image::findOrFail($id);
                        Storage::delete($img->img_path);
                        $img->update([
                            "img_path" => Storage::put("products", $image),
                        ]);
                    }
                }

                // Xóa ảnh
                if ($request->has('deleteImages')) {
                    foreach ($request->deleteImages as $id) {
                        $img = Image::findOrFail($id);
                        $img->delete();
                        Storage::delete($img->img_path);
                    }

                }
            });
            return redirect()->route("admin.product.index")->with("success", "Chỉnh sửa sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // dd($product->receipt_details);
        if ($product->receipt_details->isNotEmpty()) {
            return redirect()->back()->with("danger", "Không thể xóa SP, SP đã được nhập " . count($product->receipt_details)
                . " lần!");
        }

        try {
            DB::transaction(function () use ($product) {
                // $product->sizes()->sync([]);
                // $product->images()->delete();
                $product->delete();
            });

            // Xóa ảnh
            // if ($product->images) {
            //     foreach ($product->images as $image) {
            //         if ($image->img_path && Storage::exists($image->img_path)) {
            //             Storage::delete($image->img_path);
            //         }

            //     }
            // }

            return redirect()->route("admin.product.index")->with("success", "Xóa sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    //----------------- Phía chức năng của người dùng ----------------
    public function showListProduct(Request $request)
    {

        $quantities        = [];
        $pendingQuantities = [];
        $products          = Product::getAllActiveProduct(16, $request['name'], $request['category']);
        foreach ($products as $i => $product) {
            $product['image'] = Image::getImage($product['product_id']);
            $product['price'] = SalePrice::query()->where("product_id", $product['product_id'])->first();
            $product['sizes'] = Size::getSizeActiveInWarehouse($product['product_id']);
            // dd($request->all(), $product['sizes']);
            // Tìm theo size
            foreach ($product['sizes'] as $size) {
                // Lấy tổng SL sản phẩm của tổng các kho đang được kích hoạt
                $quantities[$product['product_id']][$size] = WarehouseDetail::getQuantityActive($product['product_id'], $size);

                // Lấy ra tổng SL sản phẩm đang được chờ duyệt đơn
                $pendingQuantities[$product['product_id']][$size] = Order::getAllProductPendingQuantity($product['product_id'], $size);
            }
        }
        $categories     = Category::query()->get();
        $categorySearch = Category::find($request['category']);
        $sizes          = Size::get()->all();
        // dd($products->all());

        return view("pages.components.product", [
            "products"          => $products,
            "categories"        => $categories,
            "quantities"        => $quantities,
            "pendingQuantities" => $pendingQuantities,
            "name"              => $request['name'] ?? null,
            "categorySearch"    => $categorySearch,
            "sizes"             => $sizes,
        ]);
    }

    public function productDetail(Product $product)
    {
        // dd($product);
        $product->load("sizes", "images", "sale_prices", "evaluates");
        $product->evaluates->load("order");
        $countEvaluate = Evaluate::countEvaluate($product['id']);
        $averageRate   = Evaluate::averageRate($product['id']);
        $allProducts   = Product::getAllActiveProduct();
        foreach ($allProducts as $suggest) {
            $suggest['price'] = SalePrice::getPrice($suggest['product_id']);
            $suggest['image'] = Image::getImage($suggest['product_id']);
            // dd($products);
        }

        $product['sizes']  = Size::getSizeActiveInWarehouse($product['id']);
        $quantities        = [];
        $pendingQuantities = [];
        foreach ($product['sizes'] as $size) {
            // Lấy giá của từng Size
            $quantities[$product['id']][$size] = WarehouseDetail::getQuantityActive($product['id'], $size);

            // Lấy ra tổng SL sản phẩm đang được chờ duyệt đơn
            $pendingQuantities[$product['id']][$size] = Order::getAllProductPendingQuantity($product['id'], $size);
        }
        // dd($quantities);
        return view("pages.components.detail", [
            "product"           => $product,
            "allProducts"       => $allProducts,
            "countEvaluate"     => $countEvaluate,
            "averageRate"       => $averageRate,
            "quantities"        => $quantities,
            "pendingQuantities" => $pendingQuantities,
        ]);
    }
}
