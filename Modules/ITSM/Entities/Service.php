<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrackingTrait;
use Ramsey\Uuid\Uuid;

class Service extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'itsm_services';
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
        'service_number',
        'number',
        'title',
        'description',
        'kpi',
        'status',
        'work_order_id',
        'reported_id',
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

    public function serviceCategory()
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id','id');
    }
}
