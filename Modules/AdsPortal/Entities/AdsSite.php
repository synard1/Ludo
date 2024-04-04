<?php

namespace Modules\AdsPortal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class AdsSite extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'ads_sites';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'user_id',
        'sites',
        'address',
        'pic',
        'pic_phone',
        'status'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }
    
    protected static function newFactory()
    {
        return \Modules\AdsPortal\Database\factories\AdsSiteFactory::new();
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
