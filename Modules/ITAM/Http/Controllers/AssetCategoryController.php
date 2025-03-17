<?php

namespace Modules\ITAM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ITAM\Entities\Asset;
use Modules\ITAM\Entities\AssetCategory;
use Modules\ITAM\Entities\AssetType;
use Modules\ITAM\Http\DataTables\CategoryDataTable;
use Illuminate\Support\Facades\Validator;


class AssetCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index(CategoryDataTable $dataTable)
    // {
    //     addVendors(['datatables']);

    //     return $dataTable->render('itam::category.index');
    // }

    public function index()
    {
        addVendors(['datatables']);

        return view('itam::category.index');
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
        $user = auth()->user();

        // Validate input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:itam_asset_categories,name',
        ]);

        // Return validation errors if any
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->first()], 422);
        }

        try {
            // Create new category
            $category = AssetCategory::create([
                'name' => $request->input('name'),
            ]);

            return response()->json(['message' => 'Category added successfully!', 'data' => $category], 201);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to add category.' . $e], 500);
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
        $category = AssetCategory::find($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
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

        $category = AssetCategory::where('id',$id)->first();

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        $category->update([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Category updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find category
        $category = AssetCategory::find($id);

        if (!$category) {
            return response()->json(['error' => 'Category not found'], 404);
        }

        // Check if the category is being used by any assets
        $assetCount = Asset::where('category_id', $id)->count();

        if ($assetCount > 0) {
            return response()->json([
                'error' => 'Cannot delete category. It is assigned to ' . $assetCount . ' asset(s).'
            ], 400);
        }

        // Delete category if not used
        $category->delete();

        return response()->json(['message' => 'Category deleted successfully'], 200);
    }

    public function getAssetTypes($id)
    {
        $assetTypes = AssetType::where('category_id', $id)->select('id', 'name')->get(); // Select both id and name
        return response()->json($assetTypes); // Use response()->json() for consistency
    }

    public function getItamCategory(Request $request)
    {
        $user = auth()->user();
        $isSuperAdmin = $user->hasRole('Super Admin');

        $query = AssetCategory::query();

        // If not a Super Admin, restrict to user's CID
        if (!$isSuperAdmin) {
            $query->where('user_cid', $user->cid);
        }

        if ($request->filled('id')) {
            // Fetch single category with asset types
            $serviceCategory = $query->with('assetTypes')->where('id', $request->input('id'))->first();

            if (!$serviceCategory) {
                return response()->json(['error' => 'Category not found.'], 404);
            }

            return response()->json($serviceCategory, 200);
        }

        // Fetch all categories
        $categories = $query->select(['id', 'name', 'description', 'created_at']);

        if ($request->input('response_type') === 'json') {
            return response()->json($categories->get(), 200);
        }

        // Default: Return DataTables response
        return datatables()->of($categories)
            ->addColumn('action', function ($row) {
                return '<button class="btn btn-sm btn-primary edit-category" data-id="' . $row->id . '">Edit</button>
                        <button class="btn btn-sm btn-danger delete-category" data-id="' . $row->id . '" data-filter="delete_row">Delete</button>
                        <button class="btn btn-sm btn-warning view-category" data-id="' . $row->id . '" data-filter="view_row">View</button>';
            })
            ->rawColumns(['action']) // Allow HTML rendering in 'action' column
            ->toJson();
    }


}
