<?php

//author: Jood Hamdallah

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order_item extends Model
{
    protected $primaryKey = 'order_item_id'; // Single primary key


    protected $fillable = [
        'order_id',
        'menu_item_id',
        'quantity',
        'subtotal',
        'item_status',
    ];


    public function order(){
        return $this->belongsTo(Order::class, 'order_id', 'order_id');

    }
    public function menuItem(){

        return $this->belongsTo(MenuItem::class, 'menu_item_id','menu_item_id');

    }



}
