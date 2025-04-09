<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Evaluate extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "rate",
        "content",
        "order_id",
        "image",
        "product_id",
    ];

    // ---------------- Relationship -------------
    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // ---------------- Function -------------
    public static function countEvaluate($productId)
    {
        $count     = 0;
        $evaluates = Evaluate::get()->all();
        foreach ($evaluates as $evaluate) {
            if ($evaluate['product_id'] == $productId) {
                $count++;
            }
        }
        return $count;
    }

    public static function totalRate($productId)
    {
        $sum       = 0;
        $evaluates = Evaluate::get()->all();
        foreach ($evaluates as $evaluate) {
            if ($evaluate['product_id'] == $productId) {
                $sum += $evaluate['rate'];
            }
        }
        return $sum;
    }

    public static function averageRate($productId)
    {
        if (Evaluate::countEvaluate($productId) == 0) {
            return 0;
        }
        return Evaluate::totalRate($productId) / Evaluate::countEvaluate($productId);
    }
}
