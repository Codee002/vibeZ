<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Distributor extends Model
{
    protected $fillable = [
        'name',
        'email',
        'address',
    ];

    // ---------------- Relationship -------------
    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    // --------------- Function --------------
    // Lấy tổng phiếu đã nhập
    public function countReceipt()
    {
        $count = 0;
        if ($this->receipts->isNotEmpty()) {
            $count = count($this->receipts);
        }
        return $count;
    }

    // Lấy tổng phiếu đã nhập đã hoàn thành
    public function countReceiptCompleted()
    {
        $count = 0;
        if ($this->receipts->isNotEmpty()) {
            $receipts =  $this->receipts()
            ->where("status", "completed")
            ->get()
            ->all();
            $count = count($receipts);
        }
        return $count;
    }

    // Lấy tổng số lượng sản phẩm từ phiếu nhập
    public function countQuantityProduct()
    {
        $count = 0;
        foreach ($this->receipts as $receipt) {
            $count += $receipt->getQuantity();
        }
        return $count;
    }

    // Lấy tổng số lượng sản phẩm từ phiếu nhập đã hoàn thành
    public function countQuantityProductCompleted()
    {
        $count = 0;
        foreach ($this->receipts as $receipt) {
            if ($receipt['status'] == "completed") {
                $count += $receipt->getQuantity();
            }
        }
        return $count;
    }

    // Lấy tổng giá tiền đã thanh toán từ phiếu nhập đã hoàn thành
    public function getPriceCompleted()
    {
        $sum = 0;
        foreach ($this->receipts as $receipt) {
            if ($receipt['status'] == "completed") {
                foreach ($receipt->receipt_details as $detail) {
                    $sum += $detail['quantity'] * $detail['purchase_price'];
                }
            }
        }
        return $sum;
    }

}
