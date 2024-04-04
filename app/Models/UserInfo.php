<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    public $table = 'user_info';

    protected $connection = 'mysql';

    public $fillable = [
        'user_id',
        'alamat',
        'telp',
        'wa'
    ];

    protected $casts = [
        'alamat' => 'string',
        'telp' => 'string',
        'wa' => 'string'
    ];

    public static array $rules = [
        'user_id' => 'required',
        'alamat' => 'required|string|max:191',
        'telp' => 'required|string|max:191',
        'wa' => 'required|string|max:191',
        'created_at' => 'nullable',
        'updated_at' => 'nullable'
    ];

    
}
