<?php

namespace App\Models;

use Spatie\Permission\Models\Permission as SpatiePermission;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UuidTrait;

class Permission extends SpatiePermission
{
    use HasFactory;


    protected $primaryKey = 'id';
    // protected $keyType = 'string';
    // public $incrementing = false;
    // You might set a public property like guard_name or connection, or override other Eloquent Model methods/properties
}
