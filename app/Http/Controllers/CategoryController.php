<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query("search");
        $data   = collect();
        if ($search) {
            $data = Category::query()
                ->where('name', 'like', "%" . $search . "%")->paginate(3);
            return view("admin.category.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = Category::paginate(3);
        }
        return view("admin.category.index", compact('data'));
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
        try {
            DB::transaction(function () use ($category) {
                $category->delete();
            });
            return redirect()->route("admin.category.index")->with("success", "Xóa danh mục thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    public function detail(Category $category)
    {
        return view("admin.category.detail", compact('category'));
    }
}
