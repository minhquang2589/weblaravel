<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vouchers extends Model
{
    use HasFactory;
    protected $fillable = [
        'voucher_code',
        'discount_value',
        'start_date',
        'end_date',
        'voucher_quantity',
        'status',
    ];
}
