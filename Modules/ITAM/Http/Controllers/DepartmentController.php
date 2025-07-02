<?php

namespace Modules\ITAM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ITAM\Entities\Asset;
use Modules\ITAM\Entities\Department;
use Modules\ITAM\Http\DataTables\DepartmentDataTable;
use Modules\ITAM\Services\DepartmentService;

use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    protected $departmentService;

    public function __construct(DepartmentService $departmentService)
    {
        $this->departmentService = $departmentService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(DepartmentDataTable $dataTable)
    {
        addVendors(['datatables']);

        return $dataTable->render('itam::department.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('itam::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $userCid = auth()->user()->cid;

        // Validate input using service
        $validator = $this->departmentService->validateDepartment($request->all(), $userCid);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $maxAttempts = 3; // Number of retry attempts
        $attempts = 0;

        while ($attempts < $maxAttempts) {
            try {
                $department = DB::transaction(function () use ($request, $userCid) {
                    // Lock existing record
                    $existingDepartment = Department::where('name', $request->input('name'))
                        ->where('user_cid', $userCid)
                        ->lockForUpdate()
                        ->first();

                    // If department doesn't exist, create it
                    if (!$existingDepartment) {
                        return Department::create([
                            'name' => $request->input('name'),
                            'user_cid' => $userCid,
                        ]);
                    }

                    return $existingDepartment;
                });

                return response()->json([
                    'message' => 'Department added successfully!',
                    'data' => $department
                ], 201);

            } catch (Throwable $e) {
                $attempts++;

                // Log the error
                \Log::error('Department save failed: ' . $e->getMessage());

                // If max attempts reached, return error response
                if ($attempts >= $maxAttempts) {
                    return response()->json([
                        'error' => 'Failed to add Department due to a database conflict. Please try again later.'
                    ], 500);
                }

                // Short delay before retrying
                usleep(100000); // 100ms
            }
        }
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('itam::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Department::find($id);

        if (!$category) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $category = Department::where('id',$id)->first();

        if (!$category) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Department updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find category
        $category = Department::find($id);

        if (!$category) {
            return response()->json(['error' => 'Department not found'], 404);
        }

        // Check if the category is being used by any assets
        $assetCount = Asset::where('department_id', $id)->count();

        if ($assetCount > 0) {
            return response()->json([
                'error' => 'Cannot delete Department. It is assigned to ' . $assetCount . ' asset(s).'
            ], 400);
        }

        // Delete category if not used
        $category->delete();

        return response()->json(['message' => 'Department deleted successfully'], 200);
    }
}
