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


//    public function user()
//    {
//        return $this->belongsTo(Users::class, 'UserID');
//    }

//    public function tables()
//    {
//        return $this->belongsTo(Tables::class, 'TableID');
//    }
}
