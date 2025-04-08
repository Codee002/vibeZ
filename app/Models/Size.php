<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Size extends Model
{
    //
    protected $fillable = [
        'size',
    ];

    protected $primaryKey = "size";

    // ---------------- Relationship -------------
    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function sale_prices()
    {
        return $this->hasMany(SalePrice::class, 'size' . 'size');
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

    public function cart_details()
    {
        return $this->hasMany(CartDetail::class, "size", 'size');
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class, "size", 'size');
    }

    // --------------------------------------------------------------------------------
    // Lấy ra Size SP có trong kho
    public static function getSizeInWarehouse($productId)
    {
        $sizes   = [];
        $product = Product::find($productId);
        foreach ($product->warehouse_details as $detail) {
            if (! in_array($detail['size'], $sizes)) {
                $sizes[] = $detail['size'];
            }

        }
        return $sizes;
    }

    // Lấy ra Size SP đang active có trong kho
    public static function getSizeActiveInWarehouse($productId)
    {
        $sizes   = [];
        $product = Product::find($productId);
        foreach ($product->warehouse_details as $detail) {
            if ($detail['status'] == "actived" && ! in_array($detail['size'], $sizes)) {
                $sizes[] = $detail['size'];
            }
        }
        return $sizes;
    }
}
