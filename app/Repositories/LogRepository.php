<?php

namespace App\Repositories;

use App\Models\Log;
use App\Repositories\BaseRepository;

class LogRepository extends BaseRepository
{
    protected $fieldSearchable = [
        'http_method',
        'url',
        'http_status',
        'user_id',
        'ip_address',
        'user_agent'
    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return Log::class;
    }
}
