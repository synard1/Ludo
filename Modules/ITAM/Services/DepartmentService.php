<?php

namespace Modules\ITAM\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Modules\ITAM\Entities\Department;

class DepartmentService
{
    // public function handle()
    // {
    //     //
    // }

    /**
     * Validate department name.
     */
    public function validateDepartment($data, $userCid)
    {
        return Validator::make($data, [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('itam_departments', 'name')
                    ->where(function ($query) use ($userCid) {
                        $query->whereNull('deleted_at') // Exclude soft deleted records
                            ->where('user_cid', $userCid); // Ensure uniqueness within user CID
                    }),
            ],
        ]);
    }

    /**
     * Create a new department.
     */
    public function create($departmentName)
    {
        $validatedData = $this->validate($departmentName);
        return Department::create($validatedData);
    }
}
