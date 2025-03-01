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
}
