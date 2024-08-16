<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MenuItem extends Model
{
    use HasFactory;


    protected $primaryKey = 'item_id';

    protected $fillable = [
        'name_item',
        'description',
        'price',
        'availability',
        'image',
        'category_id',
    ];

    public function category()
    {
      //  return $this->belongsTo(Category::class);
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}

