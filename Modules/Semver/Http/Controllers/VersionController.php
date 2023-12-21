<?php

namespace Modules\Semver\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Semver\Http\DataTables\VersionsDataTable;
use Illuminate\Support\Facades\Config;

class VersionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(VersionsDataTable $dataTable)
    {
        $user = auth()->user();
        $status = Config::get('onexolution.semver.versionStatus');
        $types = Config::get('onexolution.semver.versionType');

        addVendors(['datatables','tinymce']);
        addJavascriptFile('assets/js/custom/settings/semver/version.js');

        $canCreateVersion = auth()->check() && auth()->user()->level_access === 'Super Admin' && $user->can('create version');
        $isSuperAdmin = auth()->check() && auth()->user()->level_access === 'Super Admin';

        return $dataTable->render('semver::version.index',compact(['canCreateVersion','isSuperAdmin','status','types']));
        // return view('semver::version.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('semver::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        //
    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('semver::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('semver::edit');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id): RedirectResponse
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        //
    }
}
