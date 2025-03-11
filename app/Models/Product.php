<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

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

    public function warehouse_details()
    {
        return $this->hasMany(WarehouseDetail::class);
    }

    public function receipt_details()
    {
        return $this->hasMany(ReceiptDetail::class);
    }

    // ----------------------------------------------------------------------------------------------
    /**
     * Lấy ra tất cả các sản phẩm
     *          Đang kích hoạt
     *          Không tính theo Size
     *          Tính chung tất cả các kho
     * Trả về Id, Tên Sản Phẩm, Tên danh mục
     */
    public static function getAllProduct($perPage = null, $search = null, $category = null)
    {
        $query = WarehouseDetail::select(
            "warehouse_details.product_id",
            // "warehouse_details.size",
            "warehouse_details.status",
            DB::raw('SUM(warehouse_details.quantity) as totalQuantity'),
            "products.name as product_name",    // Lấy tên sản phẩm
            "categories.id as category_id",     // Lấy mã danh mục
            "categories.name as category_name", // Lấy tên danh mục
        )
            ->join("products", "warehouse_details.product_id", "=", "products.id")
            ->join("categories", "products.category_id", "=", "categories.id")
            ->groupBy("warehouse_details.product_id",
                "warehouse_details.status", "products.name", "categories.name", "categories.id") // Nhóm theo id, size và status
            ->having("totalQuantity", ">", 0);

        // Tìm theo tên
        if ($search) {
            $query->where("products.name", "LIKE", "%" . $search . "%");
        }
        // Tìm theo danh mục
        if ($category) {
            $query->where("categories.id", $category);
        }

        // Phân trang
        if (! empty($perPage)) {
            $query = $query->paginate($perPage);
        } else {
            $query = $query->get();
        }

        // dd($query->toSql());
        return $query;
    }

    // Lấy ra giá sản phẩm của từng size nếu có
    public function getSalePrice($size)
    {
        foreach ($this->sale_prices as $detail) {
            if ($detail['size'] == $size) {
                return $detail['price'];
            }
        }
        return null;
    }

    // Lấy ra tổng sản phẩm trong tất cả các kho
    public function getTotalWarehouse()
    {
        return ($this->warehouse_details->sum("quantity"));
    }

    // Lấy giá nhập của sản phẩm nếu có
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
