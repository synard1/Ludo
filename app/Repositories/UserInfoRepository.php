<?php

namespace App\Repositories;

use App\Models\UserInfo;
use App\Repositories\BaseRepository;

class UserInfoRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'user_id',
        'alamat',
        'telp',
        'wa'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return UserInfo::class;
    }
}
