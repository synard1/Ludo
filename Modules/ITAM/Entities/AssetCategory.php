<?php

namespace Modules\ITAM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\UserTracking;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class AssetCategory extends Model
{
    use HasFactory, UserTracking, SoftDeletes;

    public $table = 'itam_asset_categories';
    protected $primaryKey = 'id';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'created_by',
        'user_cid',

    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        });
    }

    public function type()
    {
        return $this->hasMany(AssetType::class,'category_id','id');
    }

    public function asset()
    {
        return $this->hasMany(Asset::class,'category_id','id');
    }

    public function assetTypes()
    {
        return $this->hasMany(AssetType::class,'category_id','id');
    }
}
