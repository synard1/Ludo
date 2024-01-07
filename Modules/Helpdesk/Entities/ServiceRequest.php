<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class ServiceRequest extends Model
{
    use HasFactory, UserTrackingTrait;

    public $table = 'helpdesk_service_requests';
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
        'request_description',
        'request_date',
        'status',
        'service_id',
        'service_name',
        'requester_name',
        'requester_unit',
        'requester_cid',
    ];
    
}
