<?php

namespace Modules\ITAM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\ITAM\Http\DataTables\AssetDataTable;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(AssetDataTable $dataTable)
    {
        addVendors(['datatables']);

        return $dataTable->render('itam::asset.index');
    }

    public function indexCategory(AssetDataTable $dataTable)
    {
        addVendors(['datatables']);

        return $dataTable->render('itam::category.index');
    }

    public function indexSettings(AssetDataTable $dataTable)
    {
        addVendors(['datatables']);

        return $dataTable->render('itam::setting.index');
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
    public function store(Request $request): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            // Add your validation rules here
        ]);

        // Create the asset
        // Asset::create($validatedData);

        // Redirect back with a success message
        return redirect()->route('itam.asset.index')->with('success', 'Asset created successfully.');
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
        return view('itam::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        // Validate the request data
        $validatedData = $request->validate([
            // Add your validation rules here
        ]);

        // Find the asset and update it
        // $asset = Asset::findOrFail($id);
        // $asset->update($validatedData);

        // Redirect back with a success message
        return redirect()->route('itam.asset.index')->with('success', 'Asset updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
