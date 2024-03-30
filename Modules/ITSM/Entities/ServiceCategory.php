<?php

namespace Modules\ITSM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Ramsey\Uuid\Uuid;
use App\Traits\UserTrackingTrait;
use Illuminate\Database\Eloquent\SoftDeletes;
use Modules\ITSM\Entities\Service;

class ServiceCategory extends Model
{
    use HasFactory, UserTrackingTrait, SoftDeletes;

    public $table = 'itsm_service_categories';
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
        'name',
        'description'
    ];

    public function service()
    {
        return $this->hasMany(Service::class, 'category_id','id');
    }
    
}
