<?php

namespace Modules\Semver\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Semver\Database\factories\ChangelogFactory;

class Changelog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [];
    
    protected static function newFactory(): ChangelogFactory
    {
        //return ChangelogFactory::new();
    }
}
