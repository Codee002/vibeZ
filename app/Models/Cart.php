<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = [
        'user_id',
    ];

    // ---------------- Relationship -------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function cart_details()
    {
        return $this->hasMany(CartDetail::class);
    }
}
