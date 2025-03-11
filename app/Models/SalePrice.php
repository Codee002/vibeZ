<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalePrice extends Model
{
    //
    protected $fillable = [
        'product_id',
        'size',
        'price',
        'start_date',
        'end_date',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class, "size", "size");
    }
    //-----------------------------------------------------------------------------
    // Lấy giá của sản phẩm
    public static function getPrice($product_id)
    {
        $price = SalePrice::query()
            ->where("product_id", $product_id)
            ->first();
        return $price['price'] ?? null;
    }

    // Lấy giá của sản phẩm theo size
    public static function getPriceBySize($product_id, $size)
    {
        $price = SalePrice::query()
            ->where("product_id", $product_id)
            ->where("size", $size)
            ->first();
        return $price['price'] ?? null;
    }
}
