<?php

namespace Modules\ITAM\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\ITAM\Database\factories\AssetFactory;
use App\Traits\UserTracking;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Asset extends Model
{
    use HasFactory, UserTracking, SoftDeletes;

    public $table = 'itam_assets';
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
        'id',
        'ownership_type',
        'partner_id',
        'asset_tag',
        'name',
        'category_id',
        'type_id',
        'manufacturer_id',
        'model',
        'serial_number',
        'purchase_date',
        'purchase_cost',
        'warranty_end_date',
        'status',
        'location_id',
        'assigned_to',
        'notes',
        'specifications',
        'created_by',
    ];

    protected $casts = [
        'spesifications' => 'array',
        'purchase_date' => 'datetime',
        'warranty_end_date' => 'datetime',

    ];

    public function category()
    {
        return $this->belongsTo(AssetCategory::class, 'category_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(AssetType::class, 'type_id', 'id');
    }

    public function manufacturer()
    {
        return $this->belongsTo(Manufacture::class, 'manufacturer_id', 'id');
    }
}
