<?php

namespace Modules\AdsPortal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\AdsPortal\Http\Livewire\AdsSched;
use Ramsey\Uuid\Uuid;

class Ads extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'ads';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'user_id',
        'client_id',
        'name',
        'url',
        'duration',
        'type',
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

    public function adsSchedules()
    {
        return $this->hasMany(AdsSchedule::class, 'ads_id');
    }
    
    protected static function newFactory()
    {
        return \Modules\AdsPortal\Database\factories\AdsFactory::new();
    }
}
