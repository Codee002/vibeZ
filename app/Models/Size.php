<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    //
    protected $fillable = [
        'size'
    ];

    protected $primaryKey = "size";

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }


    // Tham số 2: Tên cột khóa ngoại của bảng warehouse_details
    // Tham số 3: Tên cột khóa chính của bảng size
    public function warehouse_details()
    {
        return $this->hasMany(WarehouseDetail::class, "size", 'size');
    }

    public function receipt_details()
    {
        return $this->hasMany(ReceiptDetail::class, "size", 'size');
    }
}
