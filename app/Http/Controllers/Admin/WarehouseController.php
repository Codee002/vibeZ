<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\Warehouse;
use App\Models\WarehouseDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $data = $data = Warehouse::query();

        if ($request['address']) {
            $data = $data->where('address', 'like', "%" . $request['address'] . "%");
        }

        $data = $data->orderBy("capacity", $request['capacity'] ?? "asc");

        $data = $data->paginate(8);

        return view("admin.warehouse.index", [
            "data"     => $data,
            "address"  => $request['address'] ?? "",
            "capacity" => $request['capacity'] ?? "",
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.warehouse.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreWarehouseRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Warehouse::query()->create($request->all());
            });
            return redirect()->route("admin.warehouse.index")->with("success", "Thêm kho thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, Warehouse $warehouse)
    {
        $warehouse_details = $warehouse->warehouse_details();
        $warehouse->load('warehouse_details');

        foreach ($warehouse_details as $warehouse_detail) {
            $warehouse_detail->load('product', 'size');
        }

        if ($request['name']) {
            $warehouse_details = $warehouse_details->whereHas('product', function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request['name'] . '%');
            });
        }

        if ($request['status']) {
            $warehouse_details = $warehouse_details->where('status', $request['status']);
        }
        $warehouse_details = $warehouse_details->paginate(8);
        return view("admin.warehouse.show", [
            'warehouse'         => $warehouse,
            'warehouse_details' => $warehouse_details,
            'name'              => $request['name'] ?? "",
            'status'            => $request['status'] ?? "",
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Warehouse $warehouse)
    {
        return view("admin.warehouse.edit", compact('warehouse'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateWarehouseRequest $request, Warehouse $warehouse)
    {
        try {
            DB::transaction(function () use ($request, $warehouse) {
                $warehouse->update($request->all());
            });
            return redirect()->route("admin.warehouse.index")->with("success", "Chỉnh sửa kho thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Warehouse $warehouse)
    {
        // dd($warehouse->receipts);
        if ($warehouse->receipts->isNotEmpty()) {
            return redirect()->back()->with("danger", "Không thể xóa kho, có " . count($warehouse->receipts)
                . " phiếu nhập thuộc kho này!");
        }

        try {
            DB::transaction(function () use ($warehouse) {
                $warehouse->delete();
            });
            return redirect()->route("admin.warehouse.index")->with("success", "Xóa kho thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    public function activedProduct(WarehouseDetail $warehouse_detail)
    {
        try {
            DB::transaction(function () use ($warehouse_detail) {
                $warehouse_detail->update(['status' => "actived"]);
            });
            return redirect()->back()->with("success", "Kích hoạt sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }

    }
    public function disabledProduct(WarehouseDetail $warehouse_detail)
    {
        try {
            DB::transaction(function () use ($warehouse_detail) {
                $warehouse_detail->update(['status' => "disabled"]);
            });
            return redirect()->back()->with("success", "Hủy kích hoạt sản phẩm thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }

    }

    public function destroyWarehouseDetail(WarehouseDetail $warehouseDetail)
    {
        try {
            DB::transaction(function () use ($warehouseDetail) {
                $warehouseDetail->delete();
            });
            return redirect()->back()->with("success", "Xóa sản phẩm khỏi kho thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }
}
