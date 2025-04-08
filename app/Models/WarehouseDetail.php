<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class WarehouseDetail extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'warehouse_id',
        'product_id',
        'size',
        'quantity',
        'status',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Tham số thứ 2: Tên khóa ngoại của bảng Warehouses
    // Tham số thứ 3: Tên khóa chính của bảng size
    public function size()
    {
        return $this->belongsTo(Size::class, 'size', 'size');
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    // ---------------------------------------------------------------------------------
    // Lấy ra tổng SL SP đang active của tổng các kho
    public static function getQuantityActive($productId, $size)
    {
        $details = WarehouseDetail::query()
        ->where("product_id", $productId)
        ->where("size", $size)
        ->get();
        $quantity = 0;
        foreach ($details as $detail)
        {
            $quantity += $detail['quantity'];
        }
        return $quantity;
    }
}
