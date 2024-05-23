<?php

namespace App\Models;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriber extends Model implements Authenticatable
{
    // 
    protected $fillable = ['subemail'];
    public function getAuthIdentifierName()
    {
        return 'subemail';
    }

    public function getAuthIdentifier()
    {
        return $this->getAttribute('subemail');
    }

    public function getAuthPassword(){
        return null;
    }
        
    

    public function getAuthPasswordName()
    {
        return 'password';
    }

    public function getRememberToken()
    {
        return null;
    }

    public function setRememberToken($value)
    {
    }

    public function getRememberTokenName()
    {
        return null;
    }
}
