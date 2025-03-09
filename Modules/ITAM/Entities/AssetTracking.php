<?php

namespace Modules\ITAM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ITAM\Database\factories\AssetTrackingFactory;

class AssetTracking extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): AssetTrackingFactory
    {
        //return AssetTrackingFactory::new();
    }
}
