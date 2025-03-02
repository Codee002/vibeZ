<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReceiptDetail extends Model
{
    protected $fillable = [
        'receipt_id',
        'product_id',
        'size',
        'quantity',
        'purchase_price',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Tham số thứ 2: Tên khóa ngoại của bảng Warehouses
    // Tham số thứ 3: Tên khóa chính của bảng size
    public function size()
    {
        return $this->belongsTo(Size::class);
    }

    public function receipt()
    {
        return $this->belongsTo(Receipt::class);
    }
}
