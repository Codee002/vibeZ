<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseDetail extends Model
{
    protected $fillable = [
        'quantity',
        'size',
        'product_id',
        'warehouse_id',
        'status'
    ];

    public function product()
    {
        $this->belongsTo(Product::class);
    }

    // Tham số thứ 2: Tên khóa ngoại của bảng Warehouses
    // Tham số thứ 3: Tên khóa chính của bảng size
    public function size()
    {
        $this->belongsTo(Size::class, 'size', 'size');
    }

    public function warehouse()
    {
        $this->belongsTo(Warehouse::class);
    }
}
