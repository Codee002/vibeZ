<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRankRequest;
use App\Http\Requests\UpdateRankRequest;
use App\Models\Rank;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RankController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search = $request->query("search");
        $data   = collect();
        if ($search) {
            $data = Rank::query()
            ->where('name', 'like', "%" . $search . "%")
            ->orderBy('point')
            ->paginate(8);
            return view("admin.rank.index", ['data' => $data, 'search' => $search]);

        } else {
            $data = Rank::orderBy('point')->paginate(8);
        }
        return view("admin.rank.index", compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.rank.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRankRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                Rank::query()->create($request->all());
            });
            return redirect()->route("admin.rank.index")->with("success", "Thêm cấp thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Rank $rank)
    {
        $users = $rank->getUser();
        foreach ($users as $user) {
            $user['rank']                  = $user->getRank();
            $user['count_all_order']       = $user->countAllOrder();
            $user['count_order_completed'] = $user->countOrderCompleted();
            $user['order_price']           = $user->getOrderPriceCompleted();
            // dd($data->all(), $user);
        }
        return view("admin.rank.show", compact('rank', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Rank $rank)
    {
        return view("admin.rank.edit", compact('rank'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRankRequest $request, Rank $rank)
    {
        try {
            DB::transaction(function () use ($request, $rank) {
                $rank->update($request->all());
            });
            return redirect()->route("admin.rank.index")->with("success", "Chỉnh sửa cấp thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Rank $rank)
    {
        try {
            DB::transaction(function () use ($rank) {
                $rank->delete();
            });
            return redirect()->route("admin.rank.index")->with("success", "Xóa cấp thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage());
        }
    }
}
