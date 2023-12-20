<?php

namespace Modules\Semver\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Semver\Database\factories\VersionFactory;

class Version extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): VersionFactory
    {
        //return VersionFactory::new();
    }
}
