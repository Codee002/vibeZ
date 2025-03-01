<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalePrice extends Model
{
    //
    protected $fillable = [
        'product_id',
        'price',
        'start_date',
        'end_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
