<?php

namespace Modules\UserInfo\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [];
    
    protected static function newFactory()
    {
        return \Modules\UserInfo\Database\factories\CompanyFactory::new();
    }
}
