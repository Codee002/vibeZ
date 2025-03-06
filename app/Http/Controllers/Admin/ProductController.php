<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\Size;
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
        $search = $request->query("search");
        $data   = collect();
        if ($search) {
            $data = Product::query()
                ->where('name', 'like', "%" . $search . "%")
                ->with(['categories', 'images', 'sizes'])
                ->paginate(3);
            return view("admin.product.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = Product::with(['category', 'images', 'sizes'])->paginate(3);
        }
        return view("admin.product.index", compact('data'));
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
        if ($product->images->count() == count($request->deleteImages))
        {
            return redirect()->route("admin.product.edit", $product)->with("danger", "Sản phẩm phải có ít nhất 1 hình ảnh");
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
        try {
            DB::transaction(function () use ($product) {
                $product->sizes()->sync([]);
                $product->images()->delete();
                $product->delete();
            });
            if ($product->images) {
                foreach ($product->images as $image) {
                    if ($image->img_path && Storage::exists($image->img_path)) {
                        Storage::delete($image->img_path);
                    }

                }
            }
            return redirect()->route("admin.product.index")->with("success", "Xóa sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }
}
