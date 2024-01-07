<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Helpdesk\Http\DataTables\ServiceManagementDataTable;
use Modules\Helpdesk\Http\DataTables\ServiceRequestDataTable;
use Modules\Helpdesk\Entities\Service;

class ServiceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceRequestDataTable $dataTable)
    {
        addVendors(['datatables','tinymce']);
        addJavascriptFile('assets/js/custom/apps/helpdesk/service.js');
        
        $user = auth()->user();
        $canCreateService = auth()->check() && auth()->user()->level_access === 'Supervisor' && $user->can('create service management');
        $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
        $services = Service::where('user_cid',$user->cid)->orderBy('name','asc')->get();
        

        return $dataTable->render('helpdesk::service-management.index',compact(['canCreateService','isSupervisor','services']));
        // return view('helpdesk::service-management.index',compact(['canCreateService','isSupervisor']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('helpdesk::create');
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
        return view('helpdesk::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('helpdesk::edit');
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
