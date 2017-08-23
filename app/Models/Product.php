<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = "m_products";
    protected $fillable = ['name', 'image', 'indexing', 'description', 'category_id'];
}
