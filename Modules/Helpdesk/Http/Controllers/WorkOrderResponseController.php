<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Helpdesk\Entities\WorkOrderResponse;

class WorkOrderResponseController extends Controller
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

    public function getData($id)
    {
        $woResponse = WorkOrderResponse::where('work_order_id',$id)->first();
        if ($woResponse) {

            // Decode the JSON columns
            $woResponse->ticket_payload = json_decode($woResponse->ticket_payload);
            $woResponse->workorder_payload = json_decode($woResponse->workorder_payload);
            $woResponse->workorder_payload->ticket_details = json_decode($woResponse->workorder_payload->ticket_details);

            // $woResponse->workorder_payload['ticket_details'] = json_decode($woResponse->workorder_payload['ticket_details']);

            return response()->json($woResponse);

        } else {
            return response()->json(['message' => 'Work Order Response not found'], 404);
        }
    }
}
