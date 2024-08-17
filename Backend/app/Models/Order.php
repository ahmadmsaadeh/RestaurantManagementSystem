<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'order_date',
        'order_time',
        'user_id',
        'reservation_id',
        'total',
        'status',
    ];

    public function Order_Item(){
     
        return $this->hasMany(Order_item::class, 'order_id', 'order_id');

    }
    public function reservation(){

      return $this->belongsTo(Reservation::class);

    }
    public function feedback(){

        return $this->hasMany(Feedback::class);

    }
    public function user(){

        return $this->belongsTo(User::class);

    }
}
