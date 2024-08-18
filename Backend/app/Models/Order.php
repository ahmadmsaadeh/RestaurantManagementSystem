<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $primaryKey = 'order_id';
    protected $fillable = [

        'user_id',
        'reservation_id',
        'total',
        'status',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id','user_id');
    }

    public function reservation()
    {
        return $this->belongsTo(Reservation::class, 'reservation_id','ResID');
    }

    public function orderItems()
    {
        return $this->hasMany(Order_Item::class, 'order_id','order_id');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class, 'order_id','order_id');
    }
}
