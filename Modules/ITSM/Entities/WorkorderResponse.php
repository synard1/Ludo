<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Traits\UserTrackingTrait;

class WorkorderResponse extends Model
{
    use HasFactory, UserTrackingTrait;

    public $table = 'itsm_workorder_responses';
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
        'workorder_id',
        'description',
        'module',
        'status',
        'publish',
        'start_time',
        'end_time',
        'duration',
        'notes',
        'user_cid',
        'user_id',
        'created_by',
        'created_by_level',
    ];

    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class, 'workorder_id', 'id');
    }
}
