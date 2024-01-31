<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class WorkOrder extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'itsm_work_orders';
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
        'number',
        'workorder_number',
        'workorder_number_custom',
        'supervisor',
        'staff',
        'location',
        'user',
        'subject',
        'description',
        'status',
        'priority',
        'module',
        'sla_id',
        'sla_name',
        'data_id',
        'data_details',
        'due_date',
        'report_time',
        'response_time',
        'resolved_time',
        'start_time',
        'end_time',
        'user_cid',
        'user_id',
        'created_by',
        'created_by_level',
    ];

    protected $casts = [
        'staff' => 'array',
    ];

    public function respons()
    {
        return $this->hasMany(WorkorderResponse::class, 'workorder_id','id');
    }
}
