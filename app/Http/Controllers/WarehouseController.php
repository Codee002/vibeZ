<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreWarehouseRequest;
use App\Http\Requests\UpdateWarehouseRequest;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        $data   = collect();
        if ($search) {
            $data = Warehouse::query()
                ->where('address', 'like', "%" . $search . "%")->paginate(3);
            return view("admin.warehouse.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = Warehouse::paginate(3);
        }
        return view("admin.warehouse.index", compact('data'));
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
    public function show(Warehouse $warehouse)
    {
        return view("admin.warehouse.show", compact('warehouse'));
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
        try {
            DB::transaction(function () use ($warehouse) {
                $warehouse->delete();
            });
            return redirect()->route("admin.warehouse.index")->with("success", "Xóa kho thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }
}
