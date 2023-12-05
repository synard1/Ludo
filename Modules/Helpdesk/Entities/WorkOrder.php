<?php

namespace Modules\Helpdesk\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use App\Models\User;
use App\Traits\UserTrackingTrait;
use Modules\Helpdesk\Entities\Ticket;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkOrder extends Model
{
    use HasFactory,SoftDeletes;
    use UserTrackingTrait;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'no',
        'no_workorder',
        'no_workorder_custom',
        'supervisor',
        'origin_unit',
        'staff',
        'user',
        'subject',
        'description',
        'status',
        'priority',
        'ticket_id',
        'ticket_details',
        'due_date',
    ];

    public static array $rules = [
        'origin_unit' => 'required|string',
    ];

    public $table = 'work_orders';
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

    public function setStaffAttribute($value)
    {
        $this->attributes['staff'] = json_encode($value);
    }

    public function getStaffAttribute($value)
    {
        return json_decode($value, true);
    }

    public function setIssueCategoryAttribute($value)
    {
        $this->attributes['issue_category'] = json_encode($value);
    }

    public function getIssueCategoryAttribute($value)
    {
        return json_decode($value, true);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function ticket()
    // {
    //     return $this->belongsTo(Ticket::class);
    // }

    public function ticket(): BelongsTo
    {
        return $this->belongsTo(Ticket::class);
    }

    public function getUserNameAttribute()
    {
        return $this->user->name;
    }
}
