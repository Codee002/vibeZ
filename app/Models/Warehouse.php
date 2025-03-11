<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'address',
        'capacity',
    ];

    public function receipts()
    {
        return $this->hasMany(Receipt::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }

    public function warehouse_details()
    {
        return $this->hasMany(WarehouseDetail::class);
    }

    public function issetProductSize($productId, $size)
    {
        $warehouse_details = $this->warehouse_details->where("product_id", $productId)
            ->where("size", $size)
            ->first();

        // dd($warehouse_details);
        return $warehouse_details;
    }

    // ---------------------------------------------------------------------------------
    // Lấy ra tổng số lượng sản phẩm của 1 kho
    public function getQuantity()
    {
        return $this->warehouse_details->sum('quantity');
    }

    // Lấy ra số lượng sản phẩm trong kho đang actived của 1 kho
    public function getQuantityActived()
    {
        return $this->warehouse_details->where("status", "actived")->sum('quantity');
    }

    // Lấy ra số lượng sản phẩm trong kho đang disable của 1 kho
    public function getQuantityDisabled()
    {
        return $this->warehouse_details->where("status", "disabled")->sum('quantity');
    }

    // Lấy ra phiếu nhập đang xử lý
    public function receiptsPending()
    {
        return $this->hasMany(Receipt::class)
            ->where("status", "pending");
    }

    // Lấy ra phiếu nhập đã xử lý
    public function receiptsCompleted()
    {
        return $this->hasMany(Receipt::class)
            ->where("status", "completed");
    }

    // Lấy ra số lượng sản phẩm đang chờ xử lý trong phiếu nhập
    public function getQuantityPending()
    {
        // dd($this->receiptsPending);
        $quantity = 0;
        foreach ($this->receiptsPending as $receipt) {
            // dd($receipt->getQuantity());
            $quantity += $receipt->getQuantity();
        }
        return $quantity;
    }

    // Lấy ra số lượng sản phẩm đã xử lý trong phiếu nhập
    public function getQuantityCompleted()
    {
        $quantity = 0;
        foreach ($this->receiptsCompleted as $receipt) {
            $quantity += $receipt->getQuantity();
        }
        return $quantity;
    }
}
