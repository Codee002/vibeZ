<?php
namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreEvaluateRequest;
use App\Http\Requests\UpdateEvaluateRequest;
use App\Models\Evaluate;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class EvaluateController extends Controller
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
    public function create(Order $order)
    {
        // Kiểm tra hợp lệ
        $user = Auth::user();
        if ($order['user_id'] != $user['id']) {
            abort(403);
        }

        // Kiểm tra truy cập
        if ($order->evaluates->isNotEmpty()) {
            return redirect()->route("evaluate.show", $order);
        }

        $listProductOrder = $order->getListProductOrder();

        // dd($listProductOrder);
        return view("pages.components.evaluate_create", [
            'listProductOrder' => $listProductOrder,
            'order'            => $order,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreEvaluateRequest $request, Order $order)
    {
        // dd($request->all(), is_array($request->images), is_array($request->contents));
        try {
            DB::transaction(function () use ($request, $order) {
                foreach ($request->ratings as $productId => $rate) {

                    // Xử lý ảnh nếu có
                    $image = null;

                    if (is_array($request->images) && array_key_exists($productId, $request->images)) {
                        $image = Storage::put("evaluates", $request->images[$productId]);
                    }

                    // Xử lý content nếu có
                    $content = "";
                    if (is_array($request->contents) && array_key_exists($productId, $request->contents)) {
                        $content = $request->contents[$productId];
                    }

                    $dataEvaluate = [
                        "rate"       => $rate,
                        "content"    => $content,
                        "order_id"   => $order['id'],
                        "image"      => $image,
                        "product_id" => $productId,
                    ];
                    Evaluate::query()->create($dataEvaluate);
                }
            });
            return redirect()->route("evaluate.show", $order)->with("success", "Đánh giá thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Order $order)
    {
        $order->evaluates->load("product");
        // Kiểm tra hợp lệ
        $user = Auth::user();
        if ($order['user_id'] != $user['id']) {
            abort(403);
        }
        $listProductOrder = $order->getListProductOrder();

        // dd($listProductOrder);
        return view("pages.components.evaluate_show", [
            'listProductOrder' => $listProductOrder,
            'order'            => $order,
        ]);

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order, Evaluate $evaluate)
    {
        $order->evaluates->load("product");
        // Kiểm tra hợp lệ
        $user = Auth::user();
        if ($order['user_id'] != $user['id']) {
            abort(403);
        }
        $listProductOrder = $order->getListProductOrder();

        return view("pages.components.evaluate_edit", [
            'listProductOrder' => $listProductOrder,
            'order'            => $order,
            'evaluate'         => $evaluate,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateEvaluateRequest $request, Order $order, Evaluate $evaluate)
    {
        try {
            DB::transaction(function () use ($request, $order, $evaluate) {
                $data = [
                    'rate' => $request['rating'],
                ];
                // Kiểm tra content
                if (! $request['content']) {
                    $data["content"] = "";
                } else {
                    $data["content"] = $request['content'];
                }

                // Xử lý ảnh nếu có
                if ($request['image']) {
                    if ($evaluate['image']) // Nếu đánh giá đó có ảnh từ trước
                    {
                        // Xóa ảnh cũ
                        Storage::delete($evaluate['image']);
                    }
                    // Tạo ảnh mới
                    $data['image'] = Storage::put("evaluates", $request['image']);
                }

                // Xử lý ảnh bị xóa
                if ($request['deleteImage'] == "true") {
                    if ($evaluate['image']) // Nếu đánh giá đó có ảnh từ trước
                    {
                        // Xóa ảnh cũ
                        Storage::delete($evaluate['image']);
                    }

                    // Tạo ảnh mới
                    $data['image'] = null;
                }

                $evaluate->update($data);
            });
            return redirect()->route("evaluate.show", $order)->with("success", "Sửa đánh giá thành công");
        } catch (\Throwable $th) {
            return redirect()->back()->with("danger", $th->getMessage())->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
