<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePayMenthodRequest;
use App\Http\Requests\UpdatePayMethodRequest;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentMethodController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        $data   = collect();
        if ($search) {
            $data = PaymentMethod::query()
                ->where('name', 'like', "%" . $search . "%")->paginate(3);
            return view("admin.payment_method.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = PaymentMethod::paginate(3);
        }
        return view("admin.payment_method.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $payMethods = PaymentMethod::pluck("status", "id")->all();
        return view("admin.payment_method.create", [
            'payMethods' => $payMethods
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePayMenthodRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $data = [
                    "name" => $request->name,
                ];
                PaymentMethod::query()->create($data);
            });
            return redirect()->route("admin.payment_method.index")->with("success", "Thêm phương thức thanh toán thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PaymentMethod $payment_method)
    {
        return view("admin.payment_method.show", compact('payment_method'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PaymentMethod $payment_method)
    {
        return view("admin.payment_method.edit", compact('payment_method'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePayMethodRequest $request, PaymentMethod $payment_method)
    {
        try {
            DB::transaction(function () use ($request, $payment_method) {
                $payment_method->update($request->all());
            });
            return redirect()->route("admin.payment_method.index")->with("success", "Chỉnh sửa phương thức thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PaymentMethod $paymentMethod)
    {
        try {
            DB::transaction(function () use ($paymentMethod) {
                $paymentMethod->delete();
            });
            return redirect()->route("admin.payment_method.index")->with("success", "Xóa phương thức thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }
}
