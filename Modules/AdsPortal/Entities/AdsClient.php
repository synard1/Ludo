<?php

namespace Modules\AdsPortal\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class AdsClient extends Model
{
    use HasFactory,SoftDeletes;

    public $table = 'ads_clients';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    public $fillable = [
        'user_id',
        'name',
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

    public function ads()
    {
        return $this->hasMany(Ads::class, 'client_id');
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    protected static function newFactory()
    {
        return \Modules\AdsPortal\Database\factories\AdsClientFactory::new();
    }
}
