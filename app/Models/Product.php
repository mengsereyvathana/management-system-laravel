<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand_id', 'name', 'slug', 'sku', 'description', 'image', 'quantity', 'price', 'is_visible', 'is_featured', 'type', 'published_at'
    ];

    //a product can have a brand
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    //relationship between product and category (many to many)
    //a product can have many categories and a category can have many products
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class);
            //->withTimestamps(); // withTimestamps() allows for tracking when the relationship was created or updated
    }
}
