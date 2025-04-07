<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDiscountRequest;
use App\Models\Category;
use App\Models\Discount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        $data   = collect();
        if ($search) {
            $data = Discount::query()
                ->where('name', 'like', "%" . $search . "%")
                ->with("category")
                ->paginate(3);
            return view("admin.payment_method.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = Discount::with("category")->paginate(3);
        }
        return view("admin.discount.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        return view("admin.discount.create",
            ["categories" => $categories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDiscountRequest $request)
    {
        // Kiểm tra trùng ngày KM
        $discounts = Discount::query()
            ->where("category_id", $request['category_id'])
            ->get()->all();

        foreach ($discounts as $discount) {
            if (! Discount::checkDate($request['start_at'], $discount['start_at'], $discount['end_at'])
                && ! Discount::checkDate($request['end_at'], $discount['start_at'], $discount['end_at'])
                && ! Discount::checkDate($discount['start_at'], $request['start_at'], $request['end_at'])
                && ! Discount::checkDate($discount['end_at'], $request['start_at'], $request['end_at'])) {
            } else {
                $category = Category::find($request['category_id']);
                return redirect()->route("admin.discount.create")
                    ->with("danger", "Thời gian bị trùng với khuyến mãi " . $category['name'] . " đã có")
                    ->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request) {
                Discount::query()->create($request->all());
            });
            return redirect()->route("admin.discount.index")->with("success", "Thêm khuyến mãi thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Discount $discount)
    {
        $discount = $discount->load(["category"]);
        return view("admin.discount.show", compact('discount'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Discount $discount)
    {
        $categories = Category::all();
        return view("admin.discount.edit", compact('discount', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreDiscountRequest $request, Discount $discount)
    {
        // dd($request->all());
        // Kiểm tra trùng ngày KM
        $discounts = Discount::query()
            ->where("category_id", $request['category_id'])
            ->where("id", "!=", $discount['id'])
            ->get()->all();
        // dd($discounts);

        foreach ($discounts as $discountCheck) {
            if (! Discount::checkDate($request['start_at'], $discountCheck['start_at'], $discountCheck['end_at'])
                && ! Discount::checkDate($request['end_at'], $discountCheck['start_at'], $discountCheck['end_at'])
                && ! Discount::checkDate($discountCheck['start_at'], $request['start_at'], $request['end_at'])
                && ! Discount::checkDate($discountCheck['end_at'], $request['start_at'], $request['end_at'])) {
            } else {
                $category = Category::find($request['category_id']);
                return redirect()->route("admin.discount.edit", $discount)
                    ->with("danger", "Thời gian bị trùng với khuyến mãi " . $category['name'] . " đã có")
                    ->withInput();
            }
        }

        try {
            DB::transaction(function () use ($request, $discount) {
                $discount->update([
                    "category_id" => $request["category_id"],
                    "des"         => $request["des"],
                    "percent"     => $request["percent"],
                    "start_at"    => $request["start_at"],
                    "end_at"      => $request["end_at"],
                ]);
            });
            return redirect()->route("admin.discount.index")->with("success", "Sửa khuyến mãi thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Discount $discount)
    {
        try {
            DB::transaction(function () use ($discount) {
                $discount->delete();
            });
            return redirect()->route("admin.discount.index")->with("success", "Xóa khuyến mãi thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    public function activedDiscount(Discount $discount)
    {
        try {
            DB::transaction(function () use ($discount) {
                $discount->update(['status' => "actived"]);
            });
            return redirect()->back()->with("success", "Kích hoạt khuyến mãi thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }

    }
    public function disabledDiscount(Discount $discount)
    {
        try {
            DB::transaction(function () use ($discount) {
                $discount->update(['status' => "disabled"]);
            });
            return redirect()->back()->with("success", "Hủy kích hoạt khuyến mãi thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }

    }

    
}
