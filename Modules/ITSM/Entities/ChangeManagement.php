<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ITSM\Database\factories\ChangeManagementFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;
use App\Traits\UserTrackingTrait;

class ChangeManagement extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'itsm_changes';
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
        'format_id',
        'number',
        'title',
        'description',
        'type',
        'category_id',
        'tags',
        'requestor_id',
        'requestor_name',
        'priority',
        'planned_start_date',
        'planned_end_date',
        'status',
        'potentially_affected_users',
        'impact_assessment',
        'rollback_plan',
    ];

    protected $casts = [
        'tags' => 'array',
        'potentially_affected_users' => 'array',
        'planned_start_date' => 'datetime',
        'planned_end_date' => 'datetime',
    ];

    public function setPotentiallyAffectedUsersAttribute($value)
    {
        $this->attributes['potentially_affected_users'] = json_encode($value);
    }
    
    public function setTagsAttribute($value)
    {
        $this->attributes['tags'] = json_encode($value);
    }

    public function getPotentiallyAffectedUsersAttribute($value)
    {
        return json_decode($value, true);
    }
    
    public function getTagsAttribute($value)
    {
        return json_decode($value, true);
    }

    public function changeCategory()
    {
        return $this->belongsTo(ChangeCategory::class, 'category_id','id');
    }
}
