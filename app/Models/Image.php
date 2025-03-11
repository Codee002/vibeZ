<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    //
    protected $fillable = [
        'img_path',
        'product_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //-----------------------------------------------------------------------------
    // Lấy 1 ảnh của sản phẩm
    public static function getImage($product_id)
    {
        $img = Image::query()
            ->where("product_id", $product_id)
            ->first();
        return $img['img_path'] ?? null;
    }
}
