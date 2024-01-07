<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use Modules\Helpdesk\Entities\ServiceRequest;
use Modules\Helpdesk\Entities\Service;

class ServiceRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('helpdesk::index');
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

    public function saveServiceRequest(Request $request)
    {
        $user = auth()->user();
        // Retrieve the ticket data based on user_id and cid
        $service = Service::where('user_cid', $user->cid)->where('id', $request->input('service'))->first(); // Use 'first' to get a single result or null if not found

        // Start a database transaction
        DB::beginTransaction();

        try {
            $serviceRequest = ServiceRequest::create([
                'service_id' => $service->id,
                'service_name' => $service->name,
                'request_description' => $request->input('description'),
                'request_date' => $request->input('report_time'),
                'requester_name' => $request->input('reporter-dropdown'),
                'requester_unit' => $request->input('unit-dropdown'),
                'requester_cid' => $user->cid,
            ]);

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Service Request save successfully']);
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::rollback();
            //throw $th;
            return response()->json(['message' => 'Failed']);
        }

    }
}
