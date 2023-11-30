<?php

namespace Modules\Helpdesk\Entities;

use App\Traits\UserTrackingTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class WorkOrderResponse extends Model
{
    use HasFactory, SoftDeletes;
    use UserTrackingTrait;

    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'no',
        'no_workorder',
        'no_workorder_custom',
        'work_order_id',
        'work_order_subject',
        'work_order_description',
        'user',
        'response',
        'status',
        'start_time',
        'end_time',
        'staff',
        'ticket_payload',
        'workorder_payload',
        'notes'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

}
