<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Receipt extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "warehouse_id",
        'status',
    ];

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class);
    }

    public function receipt_details()
    {
        return $this->hasMany(ReceiptDetail::class);
    }

    
    public function getQuantity()
    {
        $this->hasMany(ReceiptDetail::class)->sum('quantity');
    }
}
