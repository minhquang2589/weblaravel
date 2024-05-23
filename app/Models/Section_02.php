<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section_02 extends Model
{
    protected $table = 'section_02';
    protected $fillable = [
        'title',
        'description',
        'image',
        'status',
    ];
    
}
