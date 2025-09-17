<?php

// app/Models/ProductImage.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $fillable = [
        'product_id',
        'path',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Get full URL of the image
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}
