<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestImage extends Model
{
    protected $table = 'testimage';
    protected $fillable = [
        'image_url',
    ];

}
