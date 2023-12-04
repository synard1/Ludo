<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Helpdesk\Entities\Ticket;
use Modules\Helpdesk\Entities\WorkOrderNote;

class WorkOrderNoteController extends Controller
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

    public function saveWorkOrderNotes(Request $request)
    {
        $user = auth()->user();

        $ticket = Ticket::where('id', $request->input('ticket_id'))->first();
            $notes = WorkOrderNote::create([
                'work_order_id' => $ticket->work_order_id,
                'ticket_id' => $request->input('ticket_id'),
                'response' => $request->input('notes'),
                'issue_category' => $request->input('category'),
            ]);
    
            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Notes saved or updated successfully']);

        try {
            $ticket = Ticket::where('id', $request->input('ticket_id'))->first();
            $notes = WorkOrderNote::create([
                'work_order_id' => $ticket->work_order_id,
                'ticket_id' => $request->input('ticket_id'),
                'response' => $request->input('response'),
                'issue_category' => $request->input('category'),
            ]);
    
            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Notes saved or updated successfully']);
        } catch (\Throwable $th) {
            // You can log the error or return an error response
            return response()->json(['error' => 'Error saving Notes'], 500);
        }

    }
}
