<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\UserTrackingTrait;

class WorkOrderNote extends Model
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
        'work_order_id',
        'ticket_id',
        'response',
        'issue_category',
        'status',
    ];
    

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    public function setIssueCategoryAttribute($value)
    {
        $this->attributes['issue_category'] = json_encode($value);
    }

    public function getIssueCategoryAttribute($value)
    {
        return json_decode($value, true);
    }

}
