<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ITSM\Database\factories\ServiceRequestFactory;

class ServiceRequest extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): ServiceRequestFactory
    {
        //return ServiceRequestFactory::new();
    }
}
