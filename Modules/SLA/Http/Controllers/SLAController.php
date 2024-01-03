<?php

namespace Modules\SLA\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SLA\Http\DataTables\SlaDataTable;

class SLAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SlaDataTable $dataTable)
    {
        addVendors(['datatables','tinymce']);
        // addJavascriptFile('assets/js/custom/apps/helpdesk/ticket.js');

        $user = auth()->user();
        $canCreateSla = auth()->check() && auth()->user()->level_access === 'Supervisor' && $user->can('create sla');
        $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';

        // return view('sla::index');
        return $dataTable->render('sla::newIndex',compact(['isSupervisor','canCreateSla']));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sla::create');
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
        return view('sla::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('sla::edit');
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
