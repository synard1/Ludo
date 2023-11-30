<?php

namespace App\Models;

use Spatie\Permission\Models\Role as SpatieRole;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UuidTrait;
use Illuminate\Support\Str;

class Role extends SpatieRole
{
    use HasFactory;


    protected $primaryKey = 'id';
    // protected $keyType = 'string';
    // public $incrementing = false;
    // You might set a public property like guard_name or connection, or override other Eloquent Model methods/properties

    public static function boot()
    {
        parent::boot();

        // static::creating(function ($model) {
        //     $model->{$model->getKeyName()} = (string) Str::uuid();
        // });
    }

    // public function getIncrementing()
    // {
    //     return false;
    // }

    // public function getKeyType()
    // {
    //     return 'string';
    // }
}
