<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "warehouse_id",
        'distributor_id',
        'status',
    ];

    // --------------- Relationship ------------
    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function receipt_details()
    {
        return $this->hasMany(ReceiptDetail::class);
    }

    public function distributor()
    {
        return $this->belongsTo(Distributor::class);
    }

    // ---------------- Function -------------
    // Lấy SL sản phẩm nhập của phiếu đó
    public function getQuantity()
    {
        return $this->hasMany(ReceiptDetail::class)->sum('quantity');
    }

    // Lấy giá tiền nhập của SP đó
    public function getPrice()
    {
        $sum = 0;
        foreach($this->receipt_details as $detail)
        {
            $sum += $detail['quantity'] * $detail['purchase_price'];
        }
        return $sum;
    }

    // Lấy tổng giá nhập SP (status = completed)
    public static function getPurchasePrice($productId)
    {
        $purchasePrice = 0;
        $receipts      = Receipt::with("receipt_details")->get()->all();
        foreach ($receipts as $receipt) {
            if ($receipt['status'] == "completed") {
                foreach ($receipt->receipt_details as $detail) {
                    if ($detail['product_id'] == $productId) {
                        $purchasePrice += $detail['purchase_price'] * $detail['quantity'];
                    }

                }
            }
        }
        return $purchasePrice;
    }

    // Lấy tổng SL nhập SP (status = completed)
    public static function getQuantityProduct($productId)
    {
        $quantity = 0;
        $receipts = Receipt::with("receipt_details")->get()->all();
        foreach ($receipts as $receipt) {
            if ($receipt['status'] == "completed") {
                foreach ($receipt->receipt_details as $detail) {
                    if ($detail['product_id'] == $productId) {
                        $quantity += $detail['quantity'];
                    }

                }
            }
        }
        return $quantity;
    }

    // Lấy tổng tiền nhập hàng (status = completed)
    public static function getTotalPriceCompleted($startDate = "", $endDate = "")
    {
        $price    = 0;
        $receipts = Receipt::with("receipt_details")
            ->where("status", "completed");

        // Kiểm tra nếu $startDate có giá trị
        if ($startDate !== "") {
            $receipts->where("created_at", ">=", $startDate);
            // dd($receipts);
        }

        // Kiểm tra nếu $endDate có giá trị
        if ($endDate !== "") {
            $receipts->where("created_at", "<=", $endDate);
        }

        $receipts = $receipts->get()
            ->all();

        foreach ($receipts as $receipt) {
            foreach ($receipt->receipt_details as $detail) {
                $price += $detail['purchase_price'] * $detail['quantity'];
            }
        }
        return $price;
    }

    // Lấy tổng số lượng nhập (status = completed)
    public static function getTotalQuantityCompleted($startDate = "", $endDate = "")
    {
        $quantity = 0;
        $receipts = Receipt::with("receipt_details")
            ->where("status", "completed");

        // Kiểm tra nếu $startDate có giá trị
        if ($startDate !== "") {
            $receipts->where("created_at", ">=", $startDate);
        }

        // Kiểm tra nếu $endDate có giá trị
        if ($endDate !== "") {
            $receipts->where("created_at", "<=", $endDate);
        }
        $receipts = $receipts->get()
            ->all();
        foreach ($receipts as $receipt) {
            $quantity += $receipt->receipt_details->sum("quantity");
        }
        return $quantity;
    }
}
