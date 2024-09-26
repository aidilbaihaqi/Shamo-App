<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'tags'
    ];

    public function galleries(): HasMany {
        return $this->hasMany(ProductGallery::class, 'product_id', 'id');
    }

    public function category(): BelongsTo {
        return $this->belongsTo(ProductCategory::class, 'category_id', 'id');
    }
}
