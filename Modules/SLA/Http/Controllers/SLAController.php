<?php

namespace Modules\SLA\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\SLA\Http\DataTables\SlaDataTable;
use Modules\SLA\Entities\SLA;

class SLAController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(SlaDataTable $dataTable)
    {
        addVendors(['datatables','tinymce']);
        addJavascriptFile('assets/js/custom/apps/sla/sla.js');

        $user = auth()->user();
        $canCreateSla = auth()->check() && auth()->user()->level_access === 'Owner' && $user->can('create sla');
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

    public function saveSla(Request $request)
    {
        $user = auth()->user();
        try {

            if($request->input('sla_id')){
                // Update the ticket with the new status
                SLA::where('id', $request->input('sla_id'))
                    ->where('user_cid',$user->cid)
                    ->update([
                        // 'name' => $request->input('title'),
                        'description' => $request->input('description'),
                        'duration' => $request->input('duration'),
                    ]);
            }else{
                $sla = SLA::create([
                    'name' => $request->input('title'),
                    'description' => $request->input('description'),
                    'duration' => $request->input('duration'),
                ]);
        
            }
    
            // You can return a response, e.g., a success message
            return response()->json(['message' => 'SLA saved or updated successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'Failed']);
        }

    }

    public function deleteSla($id)
    {
        // Assuming you have an authenticated user
        $user = auth()->user();

        // Check if the user has permission to delete tickets
        if ($user->can('delete sla')) {
            try {
                // Find the ticket by UUID
                $sla = SLA::where('id', $id)->firstOrFail();

                // Delete the ticket
                $sla->delete();

                // You can return a success message or redirect back
                return response()->json(['message' => 'SLA deleted successfully']);
            } catch (\Exception $e) {
                // Handle any exceptions that occur during deletion
                return response()->json(['message' => 'An error occurred during SLA deletion'], 500);
            }
        } else {
            // If the user doesn't have permission, return a forbidden response
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }

    public function getSlaData(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID

        if($request->input('sla_id')){
            $sla = SLA::where('id', $request->input('sla_id'))
                    ->where('user_cid', $user->cid)
                    ->first();
            return response()->json(['data' => $sla]);
        }

        // // Retrieve the ticket data based on user_id and cid
        // $slas = SLA::where('user_cid', $cid)->orderBy('created_at','desc')
        //     ->get(); // Use 'first' to get a single result or null if not found

        // if ($slas->isNotEmpty()) {
        //     // Transform the ticket data to include user names
        //     $formattedTickets = $slas->map(function ($sla) {
        //         return [
        //             'id' => $ticket->id,
        //             'user_name' => $ticket->user->name,
        //             'cid' => $ticket->user_cid,
        //             'subject' => $ticket->subject,
        //             'description' => $ticket->description,
        //             'origin_unit' => $ticket->origin_unit,
        //             'priority' => $ticket->priority,
        //             'source_report' => $ticket->source_report,
        //             'work_order' => $ticket->work_order_id,
        //             'issue_category' => $ticket->issue_category,
        //             'status' => $ticket->status,
        //             'created_at' => $ticket->created_at,
        //             'actionButtons' => $this->getActionButtons($ticket)
        //             // Add other attributes as needed
        //         ];
        //     });

        //         return response()->json(['data' => $formattedTickets]);
        // } else {
        //     // Ticket not found
        //     return response()->json(['data' => '']);
        //     // return response()->json(['message' => 'Ticket not found'], 404);
        // }
    }
}
