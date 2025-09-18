<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'title', 'metalink', 'description',
        'meta_title', 'meta_description', 'meta_tags',
        'province_id', 'regency_id', 'category_id',
        'price', 'luas_tanah', 'luas_bangunan',
        'kamar_tidur', 'kamar_mandi', 'status',
        'youtube_embed', 'google_map'
    ];

    public function province() {
        return $this->belongsTo(Province::class);
    }

    public function regency() {
        return $this->belongsTo(Regency::class);
    }

    public function category() {
        return $this->belongsTo(Category::class);
    }

    public function promos()
    {
        return $this->belongsToMany(Promo::class, 'product_promo');
    }

    public function facilities() {
        return $this->belongsToMany(Facility::class, 'product_facility');
    }

    public function attributes()
    {
        return $this->belongsToMany(
            PropertyAttribute::class,
            'product_attribute',
            'product_id',
            'property_attribute_id'
        )->withPivot('value')
        ->withTimestamps();
    }

    public function images() {
        return $this->hasMany(ProductImage::class);
    }

    // Formatted price
    public function getFormattedPriceAttribute() {
        return $this->price 
            ? 'Rp ' . number_format($this->price, 0, ',', '.')
            : '-';
    }

    public function getUrlAttribute()
    {
        return route('products.show', $this->metalink);
    }
}
