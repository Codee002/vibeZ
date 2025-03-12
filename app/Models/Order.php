<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    protected $fillable = [
        "status",
        "user_id",
        "discount_id",
        "delivery_info_id",
    ];

    // ---------------- Relationship -------------
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function delivery_info()
    {
        return $this->belongsTo(DeliveryInfo::class);
    }

    public function discount()
    {
        return $this->belongsTo(Discount::class);
    }

    public function evaluates()
    {
        return $this->hasMany(Evaluate::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }
}
