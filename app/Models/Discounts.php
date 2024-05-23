<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Discounts extends Model
{
    use HasFactory;
    protected $fillable = [
        'discount',
        'quantity',
        'remaining',
        'start_datetime',
        'end_datetime',
    ];
    public function productVariants()
    {
        return $this->hasMany(ProductVariant::class, 'discount_id'); 
    }
}
