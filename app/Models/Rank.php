<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rank extends Model
{
    protected $fillable = [
        'type',
        'point',
        'discount',
    ];

    // ------------ Function -----------------
    // Lấy ra DS người dùng có cấp tương ứng
    public function getUser()
    {
        $users = User::get()->all();
        $results = [];
        foreach($users as $user)
        {
            if ($user->getRank() == $this['type'])
                $results[] = $user;
        }
        return $results;
    }
}
