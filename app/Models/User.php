<?php
namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    const TYPE_ADMIN  = 'admin';
    const TYPE_MEMBER = 'member';
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'password',
        'email',
        'email_active',
        'email_token',
        'two_step_auth',
        'login_token',
        'status',
        'phone',
        'gender',
        'birthday',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password'          => 'hashed',
        ];
    }

    // ----------- RelationShip -------------
    public function cart()
    {
        return $this->hasOne(Cart::class);
    }

    public function delivery_infos()
    {
        return $this->hasMany(DeliveryInfo::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ------------------------------------------
    public function isAdmin()
    {
        return $this->role == self::TYPE_ADMIN;
    }

    public function isMember()
    {
        return $this->role == self::TYPE_MEMBER;
    }

    // Lấy ra tất cả đơn hàng
    public function countAllOrder()
    {
        $count = 0;
        if ($this->orders->isNotEmpty()) {
            $count = count($this->orders);
        }
        return $count;
    }

    // Lấy ra các đơn đã hoàn thành
    public function countOrderCompleted()
    {
        $count = 0;
        foreach ($this->orders as $order) {
            if ($order['status'] == "completing") {
                $count++;
            }

        }
        return $count;
    }

    // Lấy ra các đơn đã đang chờ
    public function countOrderCPending()
    {
        $count = 0;
        foreach ($this->orders as $order) {
            if ($order['status'] == "pending") {
                $count++;
            }

        }
        return $count;
    }

    // Lấy ra các đơn đang ship
    public function countOrderShipping()
    {
        $count = 0;
        foreach ($this->orders as $order) {
            if ($order['status'] == "shipping") {
                $count++;
            }
        }
        return $count;
    }

    // Lấy ra các đơn bị từ chối
    public function countOrderRejecting()
    {
        $count = 0;
        foreach ($this->orders as $order) {
            if ($order['status'] == "rejecting") {
                $count++;
            }

        }
        return $count;
    }

    // Lấy ra các đơn đã hủy
    public function countOrderAborting()
    {
        $count = 0;
        foreach ($this->orders as $order) {
            if ($order['status'] == "aborting") {
                $count++;
            }

        }
        return $count;
    }

    // Tính tổng tiền đã thanh toán của khách hàng (đơn hoàn thành)
    public function getOrderPriceCompleted()
    {
        $sum = 0;
        foreach ($this->orders as $order) {
            if ($order['status'] == "completing") {
                $sum += $order['total_price'];
            }

        }

        return $sum;
    }

}
