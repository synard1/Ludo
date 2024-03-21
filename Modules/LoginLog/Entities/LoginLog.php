<?php

namespace Modules\LoginLog\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UuidTrait;

class LoginLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'location',
        'device',
        'ip_address',
        'login_time',
        'description',
        'status',
    ];

    protected static function newFactory()
    {
        return \Modules\LoginLog\Database\factories\LoginLogFactory::new();
    }
}
