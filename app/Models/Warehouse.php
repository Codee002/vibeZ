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

    public function receiptsPending()
    {
        return $this->hasMany(Receipt::class)
            ->where("status", "pending");
    }

    public function receiptsCompleted()
    {
        return $this->hasMany(Receipt::class)
            ->where("status", "completed");
    }

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

    public function getQuantityCompleted()
    {
        $quantity = 0;
        foreach ($this->receiptsCompleted as $receipt) {
            $quantity += $receipt->getQuantity();
        }
        return $quantity;
    }

    public function product()
    {
        return $this->belongsToMany(Product::class);
    }

    public function warehouse_details()
    {
        return $this->hasMany(WarehouseDetail::class);
    }

    public function getQuantity()
    {
        return $this->warehouse_details->sum('quantity');
    }

    public function getQuantityActived()
    {
        return $this->warehouse_details->where("status", "actived")->sum('quantity');
    }

    public function getQuantityDisabled()
    {
        return $this->warehouse_details->where("status", "disabled")->sum('quantity');
    }

    public function issetProductSize($productId, $size)
    {
        $warehouse_details = $this->warehouse_details->where("product_id", $productId)
            ->where("size", $size)
            ->first();

        // dd($warehouse_details);
        return $warehouse_details;
    }
}
