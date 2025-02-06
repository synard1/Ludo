<?php

namespace Modules\Notification\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Notification\Database\factories\UserNotifFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class UserNotif extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'notification_users';
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
        'category_id',
        'platform_id',
        'module',
        'sub_module',
        'name',
        'description',
        'status',
        'details',
        'user_cid',
        'user_id',
        'created_by',
        'created_by_level',
    ];

    protected $casts = [
        'details' => 'array',
    ];

    public function categoryCom()
    {
        return $this->belongsTo(CategoryNotif::class);
    }

    public function platformCom()
    {
        return $this->belongsTo(PlatformNotif::class,'platform_id','id');
    }
}
