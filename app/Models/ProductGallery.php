<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Storage;

class ProductGallery extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'url'
    ];

    public function getUrlAttribute($url) {
        return config('app.url') . Storage::url($url);
    } 

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
