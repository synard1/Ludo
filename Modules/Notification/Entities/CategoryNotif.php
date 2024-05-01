<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Notification\Database\factories\CategoryNotifFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class CategoryNotif extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'notification_categories';
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
        'module',
        'sub_module',
        'name',
        'description',
        'status',
        'user_cid',
        'user_id',
        'created_by',
        'created_by_level',
    ];

    protected $casts = [
        // 'reported_category' => 'array',
    ];
    
}
