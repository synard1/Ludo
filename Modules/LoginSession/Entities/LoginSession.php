<?php

namespace Modules\LoginSession\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class LoginSession extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\LoginSession\Database\factories\LoginSessionFactory::new();
    }
}
