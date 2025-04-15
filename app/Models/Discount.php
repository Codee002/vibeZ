<?php
namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Discount extends Model
{
    use SoftDeletes;
    protected $fillable = [
        "category_id",
        "des",
        "percent",
        "status",
        "start_at",
        "end_at",
    ];

    // ---------------- Relationship -------------
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function orders()
    {
        return $this->belongsToMany(Order::class);
    }

    // ---------------- Funciton -------------
    public function getTotalDay()
    {
        $startDate = Carbon::parse($this->start_at);
        $endDate   = Carbon::parse($this->end_at);
        return $startDate->diffInDays($endDate) + 1;
    }

    // Nếu ngày cần kiểm tra nằm giữa thì trả về true, ngược lại false
    public static function checkDate($day, $start, $end)
    {
        $startDate = Carbon::parse($start);
        $endDate   = Carbon::parse($end);
        $checkDate = Carbon::parse($day);
        return $checkDate->between($startDate, $endDate);
    }

    // Lấy KM ở ngày cụ thể hiện tại
    public static function getAllDiscounts($date)
    {
        $results   = [];
        $discounts = Discount::query()
            ->with("category")
            ->get()
            ->all();
        foreach ($discounts as $discount) {
            $startDate = Carbon::parse($discount['start_at']);
            $endDate   = Carbon::parse($discount['end_at']);
            if ($date->between($startDate, $endDate)) {
                $results[] = $discount;
            }

        }
        // dd($discounts, $date, $results);
        return $results;
    }

    // Lấy KM đã kích hoạt ở ngày cụ thể hiện tại
    public static function getActivedDiscounts($date)
    {
        $results   = [];
        $discounts = Discount::getAllDiscounts($date);
        foreach ($discounts as $discount) {
            if ($discount['status'] == "actived") {
                $results[] = $discount;
            }

        }
        return $results;
    }

    // Tính tổng tiền cho các đơn hàng áp dụng KM đã hoàn thành
    public function getTotalPrice()
    {
        $sum = 0;
        $orders = $this->orders()
        ->where("status", "completing")
        ->get();
        foreach ($orders as $order)
        {
            foreach ($order->order_details as $detail)
            {
                if ($detail->product['category_id'] == $this['category_id'])
                {
                    $sum += $detail['price'] * $this['percent'] / 100;
                }
            }
        }
        return $sum;
    }
}
