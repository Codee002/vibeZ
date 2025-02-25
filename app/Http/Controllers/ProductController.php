<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreProductRequest;
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
                ->where('name', 'like', "%" . $search . "%")->paginate(3);
            return view("admin.product.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = Product::paginate(3);
        }
        return view("admin.product.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::query()->pluck("name", "id")->all();
        $sizes = Size::query()->pluck("size", "size")->all();
        return view("admin.product.create", [
            'categories' => $categories,
            'sizes' => $sizes
     ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        dd($request->all());
        try {
            DB::transaction(function () use ($request) {
                $dataProduct = [
                    "name" => $request->name,
                    "category" => $request->category,
                    "des" => $request->des,
                ];

                $product = Product::query()->create($dataProduct);
                 
                if ($request->has('images'))
                {
                    foreach ($request->images as $image)
                    {
                        Image::query()->create([
                            "product_id" => $product->id,
                            "image_path" => Storage::put("products", $image),
                        ]);
                    }
                }

                $product->sizes->attach($request->sizes);

            });
            return redirect()->route("admin.product.index")->with("success", "Thêm sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
