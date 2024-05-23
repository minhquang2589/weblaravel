<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'size_id',
        'color_id',
        'image_id',
        'quantity',
    ];
    public function category()
    {
        return $this->belongsTo(ProductCates::class, 'cate_id', 'id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_variants', 'product_id', 'color_id');
    }
    public function sizes()
    {
        return $this->belongsToMany(size::class, 'product_variants', 'product_id', 'size_id');
    }
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function checkStock($sizeId, $colorId)
    {
        $productVariant = ProductVariant::where('product_id', $this->id)
            ->where('size_id', $sizeId)
            ->where('color_id', $colorId)
            ->first();

        if ($productVariant && $productVariant->quantity > 0) {
            return true;
        } else {
            return false;
        }
    }
    //////
}
