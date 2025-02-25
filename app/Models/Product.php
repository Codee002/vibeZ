<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'name',
        'des',
        'unit'
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function sizes()
    {
        return $this->belongsToMany(Size::class);
    }
}
