<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Ramsey\Uuid\Uuid;

class Log extends Model
{
    /**
 * Soft deletes the Log model and restricts viewing of deleted items to super admin.
 *
 * @return bool True on successful soft deletion, false otherwise.
 */
    use SoftDeletes;

    public $table = 'logs';
    protected $primaryKey = 'id';
    // protected $keyType = 'string';
    // public $incrementing = false;

    public $fillable = [
        'http_method',
        'url',
        'http_status',
        'user_id',
        'ip_address',
        'user_agent',
        'db_query_time',
        'page_response_time',

    ];

    protected $casts = [
        'http_method' => 'string',
        'url' => 'string',
        'ip_address' => 'string',
        'user_agent' => 'string',
        'created_at' => 'datetime',
    ];

    public static array $rules = [
        'http_method' => 'required|string|max:191',
        'url' => 'required|string',
        'http_status' => 'required',
        'user_id' => 'required',
        'ip_address' => 'nullable|string|max:191',
        'user_agent' => 'nullable|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
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
}
