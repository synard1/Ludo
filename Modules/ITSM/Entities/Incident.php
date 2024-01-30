<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

use Modules\ITSM\Entities\Reported;
use Modules\ITSM\Entities\IncidentCategory;

class Incident extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'itsm_incidents';
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
        'category_id',
        'category_name',
        'incident_number',
        'number',
        'title',
        'description',
        'severity',
        'kpi',
        'status',
        'work_order_id',
        'reported_id',
        'user_cid',
        'user_id',
        'created_by',
        'created_by_level',
        // 'reported_by',
        // 'reported_location',
        // 'reported_source',
        // 'reported_category',
        // 'reported_date',
        // 'reported_response',
    ];

    protected $casts = [
        'reported_category' => 'array',
    ];

    public function reported()
    {
        return $this->belongsTo(Reported::class);
    }

    public function workorder()
    {
        return $this->belongsTo(WorkOrder::class, 'work_order_id', 'id');
    }

    public function incidentCategory()
    {
        return $this->belongsTo(IncidentCategory::class, 'category_id','id');
    }
    
}
