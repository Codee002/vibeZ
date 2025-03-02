<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use SoftDeletes;
    //
    protected $fillable = [
        'name',
        'des',
        'unit',
        'category_id',
    ];

    public function images()
    {
        return $this->hasMany(Image::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // Tham số 2: Tên bảng phụ
    // Tham số 3: Khóa ngoại của bảng trung gian
    // Tham số 4: Khóa ngoại của bảng trung gian
    // Tham số 5: Khóa chính của bảng hiện tại
    // Tham số 6: Khóa chính của bảng còn lại
    public function sizes()
    {
        return $this->belongsToMany(Size::class, "product_size", "product_id", "size", "id", "size");
    }

    public function sale_prices()
    {
        return $this->hasMany(SalePrice::class);
    }

    public function getSalePrice($size)
    {
        foreach ($this->sale_prices as $detail) {
            if ($detail['size'] == $size) {
                return $detail['price'];
            }
        }
        return NULL;
    }


    public function warehouse_details()
    {
        return $this->hasMany(WarehouseDetail::class);
    }

    public function getTotalWarehouse()
    {
        return ($this->warehouse_details->sum("quantity"));
    }

    public function receipt_details()
    {
        return $this->hasMany(ReceiptDetail::class);
    }

    public function getPurchasePrice($size)
    {
        // dd($this->receipt_details);
        foreach ($this->receipt_details as $detail) {
            if ($detail['size'] == $size) {
                return $detail['purchase_price'];
            }

        }
        return null;
    }
}
