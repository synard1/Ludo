<?php

namespace Modules\SLA\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\SLA\Database\factories\SLAFactory;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class SLA extends Model
{
    use HasFactory, UserTrackingTrait;

    public $table = 'sla';
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
}
