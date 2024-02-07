<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class LogBook extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'itsm_log_books';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    protected $fillable = [
        'title',
        'description',
        'status',
        'publish',
        'start_time',
        'end_time',
        'user_cid',
        'user_id',
        'created_by',
        'created_by_level',
    ];

    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
    ];
}
