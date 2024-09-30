<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Product extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;
    protected $guarded = ['id'];

    public function productsizeprice()
    {
        return $this->hasMany(ProductSizePrice::class, 'product_id');
    }

    public function productImages(){
        return $this->hasMany(ProductImage::class,'product_id');
    }
}