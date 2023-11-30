<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Company extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    // protected $keyType = 'string';
    // public $incrementing = false;

    protected $fillable = [
        'user_id',
        'cid',
        'name',
        'address',
        'phone',
        'email',
        'website',
        'logo',
        'payload',
        'communication',
        'status',
        'subscription',
        'userlink',
        'userlink2',
    ];

    protected static function boot()
    {
        parent::boot();

        // static::creating(function ($model) {
        //     $model->{$model->getKeyName()} = Uuid::uuid4()->toString();
        // });
    }

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    public function setCommunicationAttribute($value)
    {
        $this->attributes['communication'] = json_encode($value);
    }

    public function getCommunicationAttribute($value)
    {
        return json_decode($value, true);
    }
}
