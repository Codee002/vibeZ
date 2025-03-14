<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDeliveryRequest;
use App\Models\DeliveryInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryInfoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.components.delivery_create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreDeliveryRequest $request)
    {
        $userId = Auth::id();
        if (!empty($request['default'])) {
            $delivery = DeliveryInfo::query()
                ->where("user_id", $userId)
                ->where("default", 1)
                ->first();

            if ($delivery) {
                $delivery->update([
                    "default" => '0',
                ]);
            }
        }

        DeliveryInfo::query()
            ->create([
                "name"    => $request["name"],
                "address" => $request["address"],
                "phone"   => $request["phone"],
                "default" => $request["default"] ?? '0',
                "user_id" => $userId,
            ]);

        return back()->with("success", "Thêm thông tin nhận hàng thành công");
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
        dd("edit");
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        dd("craete");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
