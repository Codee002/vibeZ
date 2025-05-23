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
        // dd($request->all());
        if (! empty($request->all())) {
            if (! empty($request['end_at']) && $request['start_at'] > $request['end_at']) {
                return redirect()->back()->with("danger", "Ngày bắt đầu không được lớn hơn ngày kết thúc")->withInput();
            }
        }

        $data = $data = Discount::query()->with("category");

        if ($request['category']) {
            $data = $data->where('category_id', $request['category']);
        }

        if ($request['status']) {
            $data = $data->where('status', $request['status']);
        }

        if ($request['start_at']) {
            $data->where("start_at", ">=", $request['start_at']);
        }

        if ($request['end_at']) {
            $data->where("end_at", "<=", $request['end_at']);
        }
        $data = $data->orderBy("percent", $request['percent'] ?? "asc");

        $data = $data->paginate(8);

        $categories = Category::get()->all();
        return view("admin.discount.index", [
            "data"        => $data,
            "category_id" => $request['category'] ?? "",
            "percent"     => $request['percent'] ?? "",
            "status"      => $request['status'] ?? "",
            "start_at"    => $request['start_at'] ?? "",
            "end_at"      => $request['end_at'] ?? "",
            "categories"  => $categories,
        ]);
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
        $orders = $discount->orders()->paginate(8);
        // dd($orders);
        $discount = $discount->load(["category"]);
        return view("admin.discount.show", compact('discount', 'orders'));

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
        // dd($discount->orders);
        if ($discount->orders->isNotEmpty()) {
            return redirect()->back()->with("danger", "Không thể sửa khuyến mãi, có " . count($discount->orders)
                . " đơn hàng đã sử dụng khuyến mãi này!");
        }

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
        // dd($discount->orders);
        if ($discount->orders->isNotEmpty()) {
            return redirect()->back()->with("danger", "Không thể xóa khuyến mãi, có " . count($discount->orders)
                . " đơn hàng dùng khuyến mãi này!");
        }

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
