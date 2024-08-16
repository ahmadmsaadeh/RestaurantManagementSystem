<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected $primaryKey = 'category_id';

    protected $fillable = [
        'category_name',
    ];

    public function menuItems()
    {
       // return $this->hasMany(MenuItem::class);
       // return $this->hasMany(MenuItem::class, 'category_id', 'id');
        return $this->hasMany(MenuItem::class, 'category_id', 'category_id');

    }
}
