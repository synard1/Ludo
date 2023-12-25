<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\UserTrackingTrait;

class Notification extends Model
{
    use HasFactory, UserTrackingTrait;

    protected $fillable = [
        // ...
        'user_cid',
        'user_id',
        'created_by',
        'created_by_level',
    ];

    public function notifiable()
    {
        return $this->morphTo();
    }
}
