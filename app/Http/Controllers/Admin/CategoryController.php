<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $data = $data = Category::query();

        if ($request['name']) {
            $data = $data->where('name', 'like', "%" . $request['name'] . "%");
        }

        $data = $data->paginate(8);

        foreach ($data as $category) {
            $category['count_product'] = count($category->products);
        }

        return view("admin.category.index", [
            "data" => $data,
            "name" => $request['name'] ?? "",
        ]);
    }

    public function create()
    {
        return view("admin.category.create");
    }

    public function store(StoreCategoryRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $dataCategory = [
                    "name" => $request->name,
                ];
                Category::query()->create($dataCategory);
            });
            return redirect()->route("admin.category.index")->with("success", "Thêm danh mục thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    public function edit(Category $category)
    {
        return view("admin.category.edit", compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        try {
            DB::transaction(function () use ($request, $category) {
                $category->update($request->all());
            });
            return redirect()->route("admin.category.index")->with("success", "Chỉnh sửa danh mục thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    public function destroy(Category $category)
    {
        // dd($category->products);
        if ($category->products->isNotEmpty()) {
            return redirect()->back()->with("danger", "Không thể xóa danh mục, có " . count($category->products)
                . " SP thuộc danh mục này!");
        }

        try {
            DB::transaction(function () use ($category) {
                $category->delete();
            });
            return redirect()->route("admin.category.index")->with("success", "Xóa danh mục thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    public function show(Category $category)
    {
        return view("admin.category.show", compact('category'));
    }
}
