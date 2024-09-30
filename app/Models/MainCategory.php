<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MainCategory extends Model
{
    use HasFactory;
    protected $guarded=['id'];

    public function subcategories()
    {
        return $this->hasMany(SubCategory::class, 'main_category_id');
    }
}
