<?php

namespace Modules\AdsPortal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class AdsSchedule extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'ads_schedules';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'user_id',
        'client_id',
        'ads_id',
        'site_id',
        'ads_time',
        'url',
        'days',
        'duration',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
    
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
    public function client(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AdsClient::class, 'client_id');
    }
    public function ads(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Ads::class, 'ads_id');
    }
    public function site(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AdsSite::class, 'site_id');
    }

    protected static function newFactory()
    {
        return \Modules\AdsPortal\Database\factories\AdsScheduleFactory::new();
    }
}
