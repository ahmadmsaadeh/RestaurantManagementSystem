<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'ResID';
    protected $fillable = [
        'UserID',
        'Date',
        'Time',
        'NumOfCustomers',
        'ReservationType',
        'TableID',
        'TimeExpectedToLeave',
    ];


    public function user()
    {
        return $this->belongsTo(User::class, 'UserID', 'user_id');
    }

    public function table()
    {
        return $this->belongsTo(Table::class, 'TableID','TableID');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'reservation_id','ResID');
    }
}
