<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';

    protected $fillable = [
        'name',
    ];

    public function menuItems()
    {
       // return $this->hasMany(MenuItem::class);
        return $this->hasMany(MenuItem::class, 'category_id', 'id');
    }
}
