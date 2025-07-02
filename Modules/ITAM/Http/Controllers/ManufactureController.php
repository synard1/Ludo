<?php

namespace Modules\ITAM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

use Modules\ITAM\Entities\Asset;
use Modules\ITAM\Entities\Manufacture;
use Modules\ITAM\Http\DataTables\ManufacturerDataTable;

class ManufactureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ManufacturerDataTable $dataTable)
    {
        addVendors(['datatables']);

        return $dataTable->render('itam::manufacturer.index');
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
        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('itam_manufacturers', 'name')
                    ->where(function ($query) {
                        $query->whereNull('deleted_at') // Exclude soft deleted records
                            ->where('user_cid', auth()->user()->cid); // Enforce uniqueness only within the same user_cid
                    }),
            ],
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            // Prevent duplicate submissions using transaction & lock
            $assetType = DB::transaction(function () use ($request) {
                return Manufacture::firstOrCreate(
                    [
                        'name' => $request->input('name'),
                        'user_cid' => auth()->user()->cid,
                    ],
                    [
                        'created_at' => now(), // Ensures that only a single record is created
                        'updated_at' => now(),
                    ]
                );
            });

            return response()->json(['message' => 'Manufacturer added successfully!', 'data' => $assetType], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add Manufacturer. ' . $e->getMessage()], 500);
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
        $category = Manufacture::find($id);

        if (!$category) {
            return response()->json(['error' => 'Manufacturer not found'], 404);
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

        $category = Manufacture::where('id',$id)->first();

        if (!$category) {
            return response()->json(['error' => 'Manufacture not found'], 404);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Manufacture updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find category
        $category = Manufacture::find($id);

        if (!$category) {
            return response()->json(['error' => 'Manufacture not found'], 404);
        }

        // Check if the category is being used by any assets
        $assetCount = Asset::where('manufacturer_id', $id)->count();

        if ($assetCount > 0) {
            return response()->json([
                'error' => 'Cannot delete Manufacture. It is assigned to ' . $assetCount . ' asset(s).'
            ], 400);
        }

        // Delete category if not used
        $category->delete();

        return response()->json(['message' => 'Manufacture deleted successfully'], 200);
    }
}
