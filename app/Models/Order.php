<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        "status",
        "user_id",
        "delivery_info_id",
        "payment_method_id",
        "total_price",
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

    public function discounts()
    {
        return $this->belongsToMany(Discount::class);
    }

    public function evaluates()
    {
        return $this->hasMany(Evaluate::class);
    }

    public function order_details()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function payment_method()
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    // ---------------- Function -------------
    // Tính tổng SL hóa đơn
    public function getTotalQuantity()
    {
        $sum = 0;
        foreach ($this->order_details as $detail) {
            $sum += $detail['quantity'];
        }
        return $sum;
    }

    // Tính tổng tiền hóa đơn
    public function getTotalPrice()
    {
        $sum = 0;
        foreach ($this->order_details as $detail) {
            $sum += $detail['quantity'] * $detail['price'];
        }
        return $sum;
    }

    // Tính tổng tiền giảm giá
    public function getTotalDiscount()
    {
        $sum = 0;
        foreach ($this->discounts as $discount) {
            for ($i = 0; $i < count($this->order_details); $i++)
            // dd($this, $discount, $this->order_details[$i]);
            {
                if ($this->order_details[$i]->product['category_id'] == $discount['category_id']) {
                    $sum += $this->order_details[$i]['quantity'] * $this->order_details[$i]['price'] * $discount['percent'] / 100.0;
                }
            }

        }
        return $sum;
    }

    /**
     * Lấy ra những cặp SP - Size của 1 hóa đơn
     * key: Mã Sản phẩm (product_id)
     * value: Size (size)
     */
    public function getOrderProducts()
    {
        $results = [];
        foreach ($this->order_details as $detail) {
            // dd($this, $detail);
            $results[$detail['product_id']][] = $detail["size"];
        }
        return $results;
    }

    // Lấy SL sản phẩm của hóa đơn
    public function getQuantityProduct($productId, $size)
    {
        foreach ($this->order_details as $detail) {
            if ($detail['product_id'] == $productId &&
                $detail['size'] == $size) {
                return $detail['quantity'];
            }
        }
    }

    // Lấy tất cả SL của sản phẩm đang chờ trong hóa đơn
    public static function getAllProductPendingQuantity($productId, $size)
    {
        $quantity = 0;
        $orders   = Order::where("status", "pending")
            ->with("order_details")->get()->all();
        foreach ($orders as $order) {
            foreach ($order->order_details as $detail) {
                if ($detail['product_id'] == $productId &&
                    $detail['size'] == $size) {
                    $quantity += $detail['quantity'];
                }
            }

        }
        // dd($quantity);
        return $quantity;
    }

    // Lấy tất cả SL của sản phẩm đã bán của hóa đơn
    public static function getAllProductCompletingQuantity($productId, $size)
    {
        $quantity = 0;
        $orders   = Order::where("status", "completing")
            ->with("order_details")->get()->all();
        foreach ($orders as $order) {
            foreach ($order->order_details as $detail) {
                if ($detail['product_id'] == $productId &&
                    $detail['size'] == $size) {
                    $quantity += $detail['quantity'];
                }
            }

        }
        // dd($quantity);
        return $quantity;
    }

    // Lấy tất cả SL của sản phẩm đã bán của hóa đơn
    public static function getAllProductShippingQuantity($productId, $size)
    {
        $quantity = 0;
        $orders   = Order::where("status", "shipping")
            ->with("order_details")->get()->all();
        foreach ($orders as $order) {
            foreach ($order->order_details as $detail) {
                if ($detail['product_id'] == $productId &&
                    $detail['size'] == $size) {
                    $quantity += $detail['quantity'];
                }
            }

        }
        // dd($quantity);
        return $quantity;
    }

    // Lấy các SP đã mua của đơn hàng mà không tính theo size
    public function getListProductOrder()
    {
        $results = [];
        $tempIds = [];
        $this->load(["order_details"]);
        $this->order_details->load(["product", "size"]);
        foreach ($this->order_details as $detail) {
            if (! in_array($detail['product_id'], $tempIds)) {
                $tempIds[] = $detail['product_id'];
                $results[] = $detail;
            }
        }
        return $results;
    }

    // Lấy ra tổng SL đã bán của sản phẩm
    public static function getAllQuantityCompleting($productId, $size)
    {
        $count  = 0;
        $orders = Order::where("status", "completing")
            ->with("order_details")->get()->all();
        foreach ($orders as $order) {
            foreach ($order->order_details as $detail) {
                if ($detail['product_id'] == $productId
                    && $detail['size'] == $size) {
                    $count += $detail['quantity'];
                }
            }

        }

        // dd($price);
        return $count;
    }

    // Lấy ra tổng giá đã bán của sản phẩm
    public static function getAllPriceCompleting($productId, $size)
    {
        $priceTemp = 0;
        $orders    = Order::where("status", "completing")
            ->with("order_details")->get()->all();
        foreach ($orders as $order) {
            foreach ($order->order_details as $detail) {
                if ($detail['product_id'] == $productId
                    && $detail['size'] == $size) {
                    $priceTemp += $detail['price'] * $detail['quantity'];
                }
            }

        }

        // dd($price);
        return $priceTemp;
    }

    // Tính tổng tiền tất cả hóa đơn đã hoàn thành
    public static function getTotalPriceCompleted($startDate = "", $endDate = "")
    {
        $price  = 0;
        $orders = Order::with("order_details")
            ->where("status", "completing");

        // Kiểm tra nếu $startDate có giá trị
        if ($startDate != "") {
            // dd($startDate);
            $orders->where("created_at", ">=", $startDate);
        }

        // Kiểm tra nếu $endDate có giá trị
        if ($endDate !== "") {
            $orders->where("created_at", "<=", $endDate);
        }

        $orders = $orders->get()
            ->all();

        foreach ($orders as $order) {
            foreach ($order->order_details as $detail) {

                $price += $detail['price'] * $detail['quantity'];
            }
        }
        return $price;
    }

    // Tính tổng SL SP của tất cả hóa đơn đã hoàn thành
    public static function getTotalQuantityCompleted($startDate = "", $endDate = "")
    {
        $price  = 0;
        $orders = Order::with("order_details")
            ->where("status", "completing");

        // Kiểm tra nếu $startDate có giá trị
        if ($startDate !== "") {
            $orders->where("created_at", ">=", $startDate);
        }

        // Kiểm tra nếu $endDate có giá trị
        if ($endDate !== "") {
            $orders->where("created_at", "<=", $endDate);
        }

        $orders = $orders->get()
            ->all();
        foreach ($orders as $order) {
            // dd($order, $order->receipt_details->sum("purchase_price"));
            $price += $order->order_details->sum("quantity");
        }
        return $price;
    }

    // Tính tổng SL SP của tất cả hóa đơn đã đang giao
    public static function getTotalQuantityShipping($startDate = "", $endDate = "")
    {
        $price  = 0;
        $orders = Order::with("order_details")
            ->where("status", "shipping");

        // Kiểm tra nếu $startDate có giá trị
        if ($startDate !== "") {
            $orders->where("created_at", ">=", $startDate);
        }

        // Kiểm tra nếu $endDate có giá trị
        if ($endDate !== "") {
            $orders->where("created_at", "<=", $endDate);
        }

        $orders = $orders->get()
            ->all();
        foreach ($orders as $order) {
            // dd($order, $order->receipt_details->sum("purchase_price"));
            $price += $order->order_details->sum("quantity");
        }
        return $price;
    }

}
