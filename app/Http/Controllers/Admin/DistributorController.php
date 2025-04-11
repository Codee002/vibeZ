<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDistributorRequest;
use App\Http\Requests\UpdateDistributorRequest;
use App\Models\Distributor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        $data   = collect();
        if ($search) {
            $data = Distributor::query()
                ->where('name', 'like', "%" . $search . "%")->paginate(8);
            return view("admin.distributor.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = Distributor::paginate(8);
        }
        return view("admin.distributor.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.distributor.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDistributorRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Distributor::query()->create($request->all());
            });
            return redirect()->route("admin.distributor.index")->with("success", "Thêm nhà cung cấp thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Distributor $distributor)
    {
        $receipts = $distributor->receipts()
        ->orderBy("created_at", "desc")
        ->paginate(8);
        return view("admin.distributor.show", compact('distributor', 'receipts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Distributor $distributor)
    {
        return view("admin.distributor.edit", compact('distributor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateDistributorRequest $request, Distributor $distributor)
    {
        try {
            DB::transaction(function () use ($request, $distributor) {
                $distributor->update($request->all());
            });
            return redirect()->route("admin.distributor.index")->with("success", "Chỉnh sửa nhà cung cấp thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Distributor $paymentMethod)
    {
        try {
            DB::transaction(function () use ($paymentMethod) {
                $paymentMethod->delete();
            });
            return redirect()->route("admin.distributor.index")->with("success", "Xóa phương thức thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }
}
