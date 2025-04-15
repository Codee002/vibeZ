<?php
namespace App\Http\Controllers\Admin;

use App\Exports\AccountExport;
use App\Http\Controllers\Controller;
use App\Models\Rank;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;

class AccountController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $adminId = Auth::id();
        $data    = User::query()
            ->where('id', "!=", $adminId);

        if ($request['name']) {
            $data = $data->where('name', 'like', "%" . $request['name'] . "%");
        }

        if ($request['phone']) {
            $data = $data->where('phone', 'like', "%" . $request['phone'] . "%");
        }
        $data = $data->paginate(8);

        $ranks = Rank::get()->all();
        // dd($ranks);
        foreach ($data as $user) {
            $user['rank']                  = $user->getRank();
            $user['count_all_order']       = $user->countAllOrder();
            $user['count_order_completed'] = $user->countOrderCompleted();
            $user['order_price']           = $user->getOrderPriceCompleted();
            // dd($data->all(), $user);
        }

        return view("admin.account.index", [
            "data"  => $data,
            "ranks" => $ranks,
            "name"  => $request['name'] ?? "",
            "phone" => $request['phone'] ?? "",
            "rank"  => $request['rank'] ?? "",
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user                          = User::with("orders")->find($id);
        $user['count_all_order']       = $user->countAllOrder();
        $user['count_order_completed'] = $user->countOrderCompleted();
        $user['count_order_pending']   = $user->countOrderCPending();
        $user['count_order_shipping']  = $user->countOrderShipping();
        $user['count_order_rejecting'] = $user->countOrderRejecting();
        $user['count_order_aborting']  = $user->countOrderAborting();
        $user['order_price']           = $user->getOrderPriceCompleted();
        $user['rank']                  = $user->getRank();

        $orders = $user->orders()
            ->orderBy("created_at", "desc")
            ->paginate(8);
        // dd($user);
        return view("admin.account.show", compact('user', 'orders'));
    }

    public function exportAccounts()
    {
        $adminId = Auth::id();
        $data    = User::query()
            ->where('id', "!=", $adminId)
            ->get();

        foreach ($data as $user) {
            $user['count_all_order'] = $user->countAllOrder();
            $user['order_price']     = $user->getOrderPriceCompleted();
            $user['rank']            = $user->getRank();
        }

        $name = "TaiKhoanNguoiDung_" . Carbon::now()->format("d_m_Y") . ".xlsx";
        return Excel::download(new AccountExport($data), $name);
    }
}
