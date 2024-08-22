<?php

/**
 * @file Model For Table's Table.
 *
 * @author Ahmad Saadeh
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $primaryKey = 'TableID';
    protected $fillable = [
        'NumberOfChairs',
    ];

    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'TableID', 'TableID');
    }
}
