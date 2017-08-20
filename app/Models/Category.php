<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = "m_categories";
    protected $fillable = ['name', 'icon', 'indexing', 'description', 'parent_id'];
}
