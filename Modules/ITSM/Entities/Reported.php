<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class Reported extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'itsm_reporteds';
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

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user',
        'location',
        'source',
        'report_time',
        'response_time',
        'resolved_time',
        'category',
        'data_id',
        'data_module',
        'data_number',
        'user_cid',
        'user_id',
        'created_by',
        'created_by_level',
    ];

    protected $casts = [
        'user' => 'string',
        'location' => 'string',
        'report_time' => 'datetime',
        'response_time' => 'datetime',
        'resolved_time' => 'datetime',
        'reporter_name' => 'string',
        'source' => 'string',
        'category' => 'array',
    ];
    
}
