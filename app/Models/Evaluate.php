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
    ];

    // ---------------- Relationship -------------
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
