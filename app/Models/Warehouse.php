<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Warehouse extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'address',
        'capacity'
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

    public function getQuantity()
    {
        return $this->hasMany(WarehouseDetail::class)->sum('quantity');
    }
}
