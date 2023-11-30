<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Modules\Helpdesk\Entities\WorkOrder;
use Illuminate\Database\Eloquent\Relations\HasOne;

use App\Traits\UserTrackingTrait;


class Ticket extends Model
{
    use HasFactory,SoftDeletes;
    use UserTrackingTrait;

    protected $fillable = [
        'subject',
        'description',
        'report_time',
        'response_time',
        'resolution_time',
        'reporter_name',
        'origin_unit',
        'source_report',
        'issue_category',
        'priority',
        'status',
        'work_order_id'
    ];

    protected $casts = [
        'subject' => 'string',
        'description' => 'string',
        'report_time' => 'datetime',
        'response_time' => 'datetime',
        'resolution_time' => 'datetime',
        'reporter_name' => 'string',
        'origin_unit' => 'string',
        'source_report' => 'string',
        'issue_category' => 'string',
        'priority' => 'string',
        'status' => 'string',
        'work_order_id' => 'string',
    ];

    public static array $rules = [
        'subject' => 'required|string',
        'reporter_name' => 'nullable|string',
        'description' => 'nullable|string',
        'work_order_id' => 'nullable|string',
        'priority' => 'nullable|string',
        'origin_unit' => 'required|string',
        'source_report' => 'required|string',
        'issue_category' => 'required|string',
        'status' => 'nullable|string',
        'created_at' => 'date',
        'updated_at' => 'date',
        'resolution_time' => 'date',
        'response_time' => 'date',
        'timezone' => 'required|timezone:all'
    ];

    public $table = 'tickets';
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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function workOrders(): HasOne
    {
        return $this->hasOne(WorkOrder::class);
    }

    // public function workorder()
    // {
    //     return $this->belongsTo(WorkOrder::class);
    // }

    public function setIssueCategoryAttribute($value)
    {
        $this->attributes['issue_category'] = json_encode($value);
    }

    public function getIssueCategoryAttribute($value)
    {
        return json_decode($value, true);
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}
