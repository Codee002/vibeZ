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
        'end_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function size()
    {
        return $this->belongsTo(Size::class, "size", "size");
    }
}
