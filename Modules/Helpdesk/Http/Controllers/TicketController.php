<?php

namespace Modules\Helpdesk\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Helpdesk\Entities\Ticket;
use Modules\Helpdesk\Entities\WorkOrder;
use Modules\Helpdesk\Entities\WorkOrderResponse;
use Modules\Helpdesk\Entities\WorkOrderNote;
use App\Models\Company;
use App\Models\User;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Auth;
use App\Models\StatusHistory;
use App\Helpers\ModuleHelper;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\DB;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

        $user = auth()->user(); // Get the authenticated user's ID
        $cid = $user->cid; // Assuming 'cid' is provided in the request

        addVendors(['datatables','tinymce']);
        // addJavascriptFile('assets/js/custom/apps/helpdesk/ticket.js');

        $sourceReport = Ticket::distinct('source_report')
                                        ->where('user_cid',$cid)
                                        ->pluck('source_report')
                                        ->filter()
                                        ->toArray();

        // Retrieve distinct staff values from the database
        $distinctStaff = User::distinct('name')
                                    ->pluck('name')
                                    ->where('user_cid',$cid)
                                    ->filter()
                                    ->map(function ($staff) {
                                        // return json_decode($staff);
                                        return $staff;
                                    })->flatten()
                                    ->unique()
                                    ->values();

        // $distinctStaff = WorkOrder::distinct('staff')
        //                             ->pluck('staff')
        //                             ->filter()
        //                             ->map(function ($staff) {
        //                                 // return json_decode($staff);
        //                                 return $staff;
        //                             })->flatten()
        //                             ->unique()
        //                             ->values();

        // $staffAssign = WorkOrder::distinct('staff')
        //                                 ->where('cid',$cid)
        //                                 ->pluck('staff')
        //                                 ->filter()
        //                                 ->toArray();

        $priorities = Config::get('onexolution.priorityWorkOrder');
        $statusTicket = Config::get('onexolution.statusTicket');

        return view('helpdesk::ticket.index', compact(['sourceReport','distinctStaff', 'priorities', 'statusTicket']));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('helpdesk::create');
    }

    public function woPrint($id)
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        $workorder = WorkOrder::where('id',$id)->first();
        $company = Company::where('cid',$cid)->first();
        $ticket = Ticket::where('work_order_id',$id)->first();
        $woResponse = WorkOrderResponse::where('work_order_id',$workorder->id)->first();
        $woResponse = WorkOrderResponse::where('work_order_id',$workorder->id)->first();
        $woNotes = WorkOrderNote::where('ticket_id',$ticket->id)->where('work_order_id',$workorder->id)->orderBy('created_at','DESC')->first();
        return view('helpdesk::ticket.wo_print3', compact(['workorder','company','ticket','woResponse','woNotes']));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('helpdesk::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('helpdesk::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {

    }

    public function getTicketData(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID
        $cid = $user->cid; // Assuming 'cid' is provided in the request

        // Retrieve the ticket data based on user_id and cid
        $tickets = Ticket::where('user_cid', $cid)->orderBy('created_at','desc')
            ->get(); // Use 'first' to get a single result or null if not found

        if ($tickets->isNotEmpty()) {
            // Transform the ticket data to include user names
            $formattedTickets = $tickets->map(function ($ticket) {
                return [
                    'id' => $ticket->id,
                    'user_name' => $ticket->user->name,
                    'cid' => $ticket->user_cid,
                    'subject' => $ticket->subject,
                    'description' => $ticket->description,
                    'origin_unit' => $ticket->origin_unit,
                    'priority' => $ticket->priority,
                    'source_report' => $ticket->source_report,
                    'work_order' => $ticket->work_order_id,
                    'issue_category' => $ticket->issue_category,
                    'status' => $ticket->status,
                    'created_at' => $ticket->created_at,
                    'actionButtons' => $this->getActionButtons($ticket)
                    // Add other attributes as needed
                ];
            });

                return response()->json(['data' => $formattedTickets]);
        } else {
            // Ticket not found
            return response()->json(['tickets' => '']);
            // return response()->json(['message' => 'Ticket not found'], 404);
        }
    }

    public function getStatusHistory(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID

        // Retrieve the ticket data based on user_id and cid
        $query  = StatusHistory::where('user_cid', $user->cid)->where('data_id',$request->input('ticket_id')); // Use 'first' to get a single result or null if not found

        try {
            // Handle search query
            if ($request->has('search') && !empty($request->input('search')['value'])) {
                $search = $request->input('search')['value'];

                $query->where(function ($query) use ($search) {
                    $query->where('status', 'like', "%$search%")
                        ->orWhere('reason', 'like', "%$search%")
                        ->orWhere('created_by', 'like', "%$search%")
                        ->orWhere('created_at', 'like', "%$search%");
                });
            }

            // Continue with other DataTables server-side processing logic
            // ...

            $data = $query->get();

            return response()->json(['data' => $data]);

        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'Failed']);
        }
            
    }

    public function saveStatus(Request $request)
    {
        $user = auth()->user();
        // Retrieve the ticket data based on user_id and cid
        $ticket = Ticket::where('user_cid', $user->cid)->where('id', $request->input('ticket_id'))
            ->first(); // Use 'first' to get a single result or null if not found

        // Start a database transaction
        DB::beginTransaction();

        try {
            $statusHistory = StatusHistory::create([
                'data_id' => $request->input('ticket_id'),
                'name' => Uc($ticket->subject),
                'module' => 'Helpdesk',
                'model' => 'Ticket',
                'old_status' => $ticket->status,
                'new_status' => $request->input('status'),
                'status' => $request->input('status'),
                'reason' => $request->input('reason'),
            ]);

            // Update the ticket with the new status
            Ticket::where('id', $request->input('ticket_id'))
                    ->update([
                        'status' => $request->input('status'),
                    ]);

            // // Update the ticket with the new status
            WorkOrder::where('ticket_id', $request->input('ticket_id'))
                    ->update([
                        'status' => $request->input('status'),
                    ]);

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Status updated successfully']);
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::rollback();
            //throw $th;
            return response()->json(['message' => 'Failed']);
        }

    }

    public function saveTicket(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        // $ticket = Ticket::create([
        //     'user_id' => $userId,
        //     'cid' => $cid,
        //     'subject' => Uc($request->input('subject')),
        //     'description' => Uc($request->input('description')),
        //     'reporter_name' => Uc($request->input('reporter_name')),
        //     'report_time' => $request->input('report_time'),
        //     'origin_unit' => $request->input('origin_unit'),
        //     'issue_category' => $request->input('issue_category'),
        //     'source_report' => $request->input('source_report'),
        //     'status' => 'Open',
        // ]);

        // $statusCheck = StatusHistory::where('cid',$cid)
        //                             ->where('data_id',$ticket->id)
        //                             ->first();
        // if($statusCheck){

        // }else{
        //     // Create a new login log record
        //     StatusHistory::create([
        //         'user_id' => $user->id,
        //         'cid' => $user->cid,
        //         'data_id' => $ticket->id,
        //         'name' => $ticket->subject,
        //         'module' => 'Helpdesk',
        //         'model' => 'Ticket',
        //         'new_status' => $ticket->status,
        //         'status' => 'Active',
        //     ]);
        // }

        // // You can return a response, e.g., a success message
        // return response()->json(['message' => 'Ticket saved or updated successfully']);

        try {
            $ticket = Ticket::create([
                'subject' => Uc($request->input('subject')),
                'description' => Uc($request->input('description')),
                'reporter_name' => Uc($request->input('reporter_name')),
                'report_time' => $request->input('report_time'),
                'origin_unit' => $request->input('origin_unit'),
                'issue_category' => $request->input('issue_category'),
                'source_report' => $request->input('source_report'),
                'status' => 'Open',
            ]);

            // $statusCheck = StatusHistory::where('cid',$cid)
            //                             ->where('data_id',$ticket->id)
            //                             ->first();
            // if($statusCheck){

            // }else{
            //     // Create a new login log record
            //     StatusHistory::create([
            //         'user_id' => $user->id,
            //         'cid' => $user->cid,
            //         'data_id' => $ticket->id,
            //         'name' => $ticket->subject,
            //         'module' => 'Helpdesk',
            //         'model' => 'Ticket',
            //         'new_status' => $ticket->status,
            //         'status' => 'Active',
            //     ]);
            // }

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Ticket saved or updated successfully']);
        } catch (\Throwable $th) {
            //throw $th;
            return response()->json(['message' => 'Failed']);
        }

    }

    private function getActionButtons($ticket)
    {
        $user = Auth::user();

        if ($user->hasAnyRole(['Super Admin', 'Administrator'])) {
            return $this->getAdminButtons($ticket);
        } elseif ($user->hasRole('Support') && $user->can('delete ticket')) {
            if (isMobileBrowser()) {
                // Do something for mobile devices
                return $this->getSupportButtonsMobile($ticket, $user);
            } else {
                // Do something for non-mobile devices
                return $this->getSupportButtons($ticket, $user);
            }
            
        }

        return '';
    }

    private function getAdminButtons($ticket)
    {
        return '
            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-switch fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
            '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
            '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-button" data-id="' . $ticket->id . '"><i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></a>';
    }

    private function getSupportButtonsMobile($ticket)
    {
        return '
            <a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
            '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-button" data-id="' . $ticket->id . '"><i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></a>';
    }

    private function getSupportButtons($ticket, $user)
    {
        $buttons = '
            <a href="#" class="btn btn-light btn-active-light-primary btn-sm" data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end" data-kt-menu-flip="top-end">
                Actions
                <span class="svg-icon fs-5 m-0">
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24px" height="24px" viewBox="0 0 24 24" version="1.1">
                        <g stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                            <polygon points="0 0 24 0 24 24 0 24"></polygon>
                            <path d="M6.70710678,15.7071068 C6.31658249,16.0976311 5.68341751,16.0976311 5.29289322,15.7071068 C4.90236893,15.3165825 4.90236893,14.6834175 5.29289322,14.2928932 L11.2928932,8.29289322 C11.6714722,7.91431428 12.2810586,7.90106866 12.6757246,8.26284586 L18.6757246,13.7628459 C19.0828436,14.1360383 19.1103465,14.7686056 18.7371541,15.1757246 C18.3639617,15.5828436 17.7313944,15.6103465 17.3242754,15.2371541 L12.0300757,10.3841378 L6.70710678,15.7071068 Z" fill="currentColor" fill-rule="nonzero" transform="translate(12.000003, 11.999999) rotate(-180.000000) translate(-12.000003, -11.999999)"></path>
                        </g>
                    </svg>
                </span>
            </a>
            <!--begin::Menu-->
            <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-bold fs-7 w-125px py-4" data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-docs-table-filter="edit_row">
                    Edit
                </a>
            </div>
            <!--end::Menu item-->

            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" class="menu-link px-3" data-kt-docs-table-filter="delete_row" data-id="' . $ticket->id . '">
                    Delete
                </a>
            </div>
            <!--end::Menu item-->';

        if ($ticket->status == 'Resolved' || $ticket->status == 'Closed') {
            $buttons .= '
                <div class="separator mt-3 opacity-75"></div>
                <!--begin::Menu item-->
                <div class="menu-item px-3">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order_note" class="menu-link px-3 generate-notes" data-kt-docs-table-filter="notes" data-id="' . $ticket->id . '">
                        Notes
                    </a>
                </div>
                <!--end::Menu item-->';
        }

        $buttons .= '
            </div>
            <!--end::Menu-->
        ';

        return $buttons;
    }

    public function deleteTicket($id)
    {
        // Assuming you have an authenticated user
        $user = auth()->user();

        // Check if the user has permission to delete tickets
        if ($user->can('delete ticket')) {
            try {
                // Find the ticket by ID
                // $ticket = Ticket::findOrFail($id);

                // Find the ticket by UUID
                $ticket = Ticket::where('id', $id)->firstOrFail();

                // Check if the ticket has associated work orders
                if ($ticket->workOrders()->exists()) {
                    // If there are associated work orders, show a warning
                    return response()->json(['message' => 'Ticket has associated work orders and cannot be deleted'], 400);
                }

                // Delete the ticket
                $ticket->delete();

                // You can return a success message or redirect back
                return response()->json(['message' => 'Ticket deleted successfully']);
            } catch (\Exception $e) {
                // Handle any exceptions that occur during deletion
                return response()->json(['message' => 'An error occurred during ticket deletion'], 500);
            }
        } else {
            // If the user doesn't have permission, return a forbidden response
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }

}
