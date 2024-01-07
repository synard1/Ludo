<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Helpdesk\Database\factories\ServiceFactory;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class Service extends Model
{
    use HasFactory, UserTrackingTrait;

    public $table = 'helpdesk_services';
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
    protected $fillable = [];
    
    protected static function newFactory(): ServiceFactory
    {
        //return ServiceFactory::new();
    }
}
