<?php

namespace Modules\ITAM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ITAM\Entities\Asset;
use Modules\ITAM\Entities\AssetType;
use Modules\ITAM\Http\DataTables\TypeDataTable;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;

class AssetTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(TypeDataTable $dataTable)
    {
        addVendors(['datatables']);

        return $dataTable->render('itam::type.index');
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
            'category_id' => [
                'required',
                Rule::exists('itam_asset_categories', 'id')
                    ->whereNull('deleted_at') // Ensure category is not soft deleted
                    ->when(!auth()->user()->hasRole('Super Admin'), function ($query) {
                        return $query->where('user_cid', auth()->user()->cid); // Restrict to user's CID
                    }),
            ],
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('itam_asset_types', 'name')
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
                return AssetType::firstOrCreate(
                    [
                        'category_id' => $request->input('category_id'),
                        'name' => $request->input('name'),
                        'user_cid' => auth()->user()->cid,
                    ],
                    [
                        'created_at' => now(), // Ensures that only a single record is created
                        'updated_at' => now(),
                    ]
                );
            });

            return response()->json(['message' => 'Asset Type added successfully!', 'data' => $assetType], 201);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add asset type. ' . $e->getMessage()], 500);
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
        $category = AssetType::find($id);

        if (!$category) {
            return response()->json(['error' => 'Asset Type not found'], 404);
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

        $category = AssetType::where('id',$id)->first();

        if (!$category) {
            return response()->json(['error' => 'Asset Type not found'], 404);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Asset Type updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find category
        $category = AssetType::find($id);

        if (!$category) {
            return response()->json(['error' => 'Asset Type not found'], 404);
        }

        // Check if the category is being used by any assets
        $assetCount = Asset::where('type_id', $id)->count();

        if ($assetCount > 0) {
            return response()->json([
                'error' => 'Cannot delete type asset. It is assigned to ' . $assetCount . ' asset(s).'
            ], 400);
        }

        // Delete category if not used
        $category->delete();

        return response()->json(['message' => 'Asset Type deleted successfully'], 200);
    }

    public function getAjax(Request $request)
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super Admin');
        
        if ($request->input('task') === 'GET_ITAM_TYPE') {
            $query = AssetType::query();

            // If not a Super Admin, restrict to user's CID
            if (!$isSuperAdmin) {
                $query->where('user_cid', $user->cid);
            }

            if ($request->filled('id')) {
                // Fetch single category with asset types
                $serviceCategory = $query->with('assetTypes')->where('id', $request->input('id'))->first();
            
                return response()->json($serviceCategory, 200);
            }

            // Fetch all categories
            $transaction = $query->select(['id', 'name', 'description', 'created_at']);
            // return datatables()->of($serviceCategories)->toJson();
            return datatables()->of($transaction)
                        ->addColumn('action', function ($row) {
                            return '<button class="btn btn-sm btn-primary edit-category" data-id="' . $row->id . '">Edit</button>
                                    <button class="btn btn-sm btn-danger delete-category" data-id="' . $row->id . ' " data-filter="delete_row">Delete</button>
                                   <button class="btn btn-sm btn-warning view-category" data-id="' . $row->id . ' " data-filter="view_row">View</button>';
                        })
                        ->rawColumns(['action']) // Allow HTML rendering in 'action' column
                        ->toJson();
        }

        return response()->json(['error' => 'Invalid request'], 400);
    }
}
