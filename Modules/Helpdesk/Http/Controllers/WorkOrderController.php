<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Helpdesk\Entities\WorkOrder;
use Modules\Helpdesk\Entities\WorkOrderResponse;
use Modules\Helpdesk\Entities\Ticket;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\SignaturePad;
use App\Helpers\ModuleHelper;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        // addVendors(['datatables','tinymce','signpad']);
        addVendors(['datatables','tinymce']);
        addJavascriptFile('assets/js/custom/apps/helpdesk/workorder.js');
        // Get the original status array
        $statusWorkOrder = Config::get('onexolution.statusWorkOrder');

        // Check if the member level is 'Staff'
        if ($user->level_access === 'Staff') {
            // Remove 'Cancel' and 'Closed' statuses
            unset($statusWorkOrder['Cancel'], $statusWorkOrder['Closed']);
        }
        return view('helpdesk::workorder.index',compact(['statusWorkOrder']));
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

    public function saveWorkOrder(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        $max = WorkOrder::where('user_cid', $cid)->max('no');
        $ticket = Ticket::where('id', $request->input('ticket_id'))->first();

        $workorder = WorkOrder::create([
            'user_id' => $userId,
            'no' => $max+1,
            'no_workorder' => 'WO-'.$max+1,
            'ticket_id' => $request->input('ticket_id'),
            'origin_unit' => $ticket->origin_unit,
            'user' => $ticket->reporter_name,
            'subject' => Uc($request->input('subject')),
            'description' => $request->input('description'),
            'due_date' => $request->input('due_date'),
            'supervisor' => Uc($user->name),
            'staff' => $request->input('staff'),
            'priority' => $request->input('priority'),
            'status' => 'Open',
            'ticket_details' => json_encode($ticket),
        ]);

        $ticket2 = Ticket::where('id', $workorder->ticket_id)
                    ->update(['work_order_id' => $workorder->id,'priority' => $request->input('priority')]);

        // You can return a response, e.g., a success message
        return response()->json(['message' => 'Work Order saved or updated successfully']);


        // try {
        //     $max = WorkOrder::where('cid', $cid)->max('no');
        //     $ticket = Ticket::where('id', $request->input('tickets_id'))->first();

        //     $workorder = WorkOrder::create([
        //         'user_id' => $userId,
        //         'no' => $max+1,
        //         'no_workorder' => 'WO-'.$max+1,
        //         'tickets_id' => $request->input('tickets_id'),
        //         'origin_unit' => $ticket->origin_unit,
        //         'user' => $ticket->reporter_name,
        //         'subject' => Uc($request->input('subject')),
        //         'description' => $request->input('description'),
        //         'due_date' => $request->input('due_date'),
        //         'staff' => $request->input('staff'),
        //         'priority' => $request->input('priority'),
        //         'status' => 'Open',
        //         'ticket_details' => json_encode($ticket),
        //     ]);

        //     $ticket2 = Ticket::where('id', $workorder->tickets_id)
        //                 ->update(['work_order_id' => $workorder->id,'priority' => $request->input('priority')]);

        //     // You can return a response, e.g., a success message
        //     return response()->json(['message' => 'Work Order saved or updated successfully']);
        // } catch (\Throwable $th) {
        //     //throw $th;
        //     return response()->json(['message' => 'Failed']);
        // }

    }

    public function getWorkOrderStaff()
    {

        $user = auth()->user();
        $cid = $user->cid;

        $staffAssign = User::distinct('name')
                            ->select('name', 'level_access')
                            ->where('cid', $cid)
                            ->where('parent_id', $user->parent_id)
                            ->pluck('name')
                            ->filter()
                            ->values()
                            ->toArray();
        // $staffAssign = User::distinct('name')
        //                     ->select('name', 'level_access')
        //                     ->where('cid', $cid)
        //                     ->where('parent_id', $user->parent_id)
        //                     ->pluck('name', 'level_access')
        //                     ->filter()
        //                     ->map(function ($levelAccess, $name) {
        //                         return "$name -- $levelAccess";
        //                     })
        //                     ->values()
        //                     ->toArray();


        // $staffAssign = WorkOrder::distinct('staff')
        //                                 ->where('cid',$cid)
        //                                 ->pluck('staff')
        //                                 ->filter()
        //                                 ->toArray();

        return $staffAssign;
    }

    public function getWorkOrderData(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID
        $cid = $user->cid; // Assuming 'cid' is provided in the request

        // Retrieve the ticket data based on user_id and cid
        // $workorders = WorkOrder::where('cid', $cid)->orderBy('created_at','desc')
            // ->get(); // Use 'first' to get a single result or null if not found

        // $workorders = WorkOrder::where('user_cid', $user->cid)->get();
        $workorders = DB::table('tickets')
            ->join('work_orders', 'tickets.id', '=', 'work_orders.ticket_id')
            ->select('tickets.report_time','tickets.issue_category', 'work_orders.*')
            ->where('tickets.user_cid', $user->cid)
            ->get();

            // dd($workorders);
        if ($workorders->isNotEmpty()) {
            // Transform the ticket data to include user names
            $formattedWorkOrders = $workorders->map(function ($workorder) {
                $ticket = Ticket::where('id', $workorder->ticket_id)->first();
                return [
                    'id' => $workorder->id,
                    // 'user_name' => $workorder->user->name,
                    'cid' => $workorder->user_cid,
                    'subject' => $workorder->subject,
                    'description' => $workorder->description,
                    'description' => $workorder->description,
                    'origin_unit' => $workorder->origin_unit,
                    'priority' => $workorder->priority,
                    'user' => $workorder->user,
                    'staff' => json_decode($workorder->staff),
                    'due_date' => $workorder->due_date,
                    'issue_category' => json_decode($workorder->issue_category),
                    'status' => $workorder->status,
                    'created_by' => $workorder->created_by,
                    'created_at' => $workorder->created_at,
                    'report_time' => $workorder->report_time,
                    'actionButtons' => $this->getActionButtons($workorder)
                    // Add other attributes as needed
                ];
            });

                return response()->json(['data' => $formattedWorkOrders]);
        } else {
            return response()->json(['data' => '']);
        }
    }

    public function deleteWorkOrder($id)
    {
        $workOrder = WorkOrder::find($id);
        if ($workOrder) {
            $workOrder->delete();

            $ticket = Ticket::where('work_order_id', $id)
                        ->update(['work_order_id' => Null ]);
            return response()->json(['message' => 'Work order deleted successfully']);
        } else {
            return response()->json(['message' => 'Work order not found'], 404);
        }
    }

    private function getActionButtons($workOrder)
    {
        $user = Auth::user();
        if (ModuleHelper::isModuleActive('UserMedia')) {
            $mediaActive = true;
        }else{
            $mediaActive = false;
        }

        if ($user->hasRole('Super Admin') || $user->hasRole('Administrator') ) {
            return '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-switch fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
                '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
                '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-button" data-id="' . $workOrder->id . '"><i class="ki-duotone ki-trash fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></a>';
        } elseif ($user->hasRole('Support')  && $user->can('edit workorder')) {
            return '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm delete-button" data-id="' . $workOrder->id . '" data-subject="' . $workOrder->subject . '" data-report-time="' . $workOrder->report_time . '"><i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></a>';
        } else {
            if($mediaActive){
                if($workOrder->status == 'Resolved' || $workOrder->status == 'Closed'){
                    return '<a href="/apps/helpdesk/print/wo/' . $workOrder->id . '" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
                    '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_wo_response_image" ><i class="ki-duotone ki-file-up fs-2"><span class="path1"></span><span class="path2"></span></i></a>';
                }else{
                    return '<a href="/apps/helpdesk/print/wo/' . $workOrder->id . '" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
                    '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 generate-work-order-response" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order_response" data-id="' . $workOrder->id . '" data-subject="' . $workOrder->subject . '"><i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
                    '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#kt_modal_wo_response_image" ><i class="ki-duotone ki-file-up fs-2"><span class="path1"></span><span class="path2"></span></i></a>';
    
                }

            }else{
                if($workOrder->status == 'Resolved' || $workOrder->status == 'Closed'){
                    return '<a href="/apps/helpdesk/print/wo/' . $workOrder->id . '" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span class="path2"></span></i></a>';
                }else{
                    return '<a href="/apps/helpdesk/print/wo/' . $workOrder->id . '" target="_blank" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1"><i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span class="path2"></span></i></a>' .
                    '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm me-1 generate-work-order-response" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order_response" data-id="' . $workOrder->id . '" data-subject="' . $workOrder->subject . '" data-report-time="' . $workOrder->report_time . '"><i class="ki-duotone ki-pencil fs-2"><span class="path1"></span><span class="path2"></span></i></a>';
    
                }

            }
            
            // Handle other roles or default behavior
            // return '<a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm generate-work-order-response" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order_response" data-id="' . $workOrder->id . '" data-subject="' . $workOrder->subject . '"><i class="ki-duotone ki-printer fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></a><a href="#" class="btn btn-icon btn-bg-light btn-active-color-primary btn-sm generate-work-order-response" data-bs-toggle="modal" data-bs-target="#kt_modal_work_order_response" data-id="' . $workOrder->id . '" data-subject="' . $workOrder->subject . '"><i class="ki-duotone ki-scroll fs-2"><span class="path1"></span><span class="path2"></span><span class="path3"></span><span class="path4"></span><span class="path5"></span></i></a>';

        }
    }

    public function saveWorkOrderResponse(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        // Start a database transaction
        DB::beginTransaction();

        try {
            $workorder = WorkOrder::where('user_cid', $cid)->where('id', $request->input('workorder_id'))->first();
            $ticket = Ticket::where('work_order_id', $request->input('workorder_id'))->first();

            $woResponse = WorkOrderResponse::updateOrCreate(
                ['work_order_id' => $request->input('workorder_id'), 'user_cid' => $cid],
                ['origin_unit' => $ticket->origin_unit,
                'user' => $ticket->reporter_name,
                'no' => $workorder->no,
                'no_workorder' => $workorder->no_workorder,
                'no_workorder_custom' => $workorder->no_workorder_custom,
                'work_order_subject' => $workorder->subject,
                'work_order_description' => $workorder->description ?? '',
                'response' => $request->input('workorder_response'),
                'status' => $request->input('status'),
                'staff' => $user->name,
                'ticket_payload' => json_encode($ticket),
                'workorder_payload' => json_encode($workorder),
                'start_time' => $request->input('start_date'),
                'end_time' => $request->input('finish_date')
                ]
            );

            // Update the work order with the response start and end time
            WorkOrder::where('id', $workorder->id)
                ->update([
                    'start_time' => $woResponse->start_time,
                    'end_time' => $woResponse->end_time,
                    'status' => $woResponse->status,
                    'work_order_response' => $woResponse->id,
                ]);

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Work Order Response saved or updated successfully']);
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();

            // You can log the error or return an error response
            return response()->json(['error' => 'Error saving Work Order Response'], 500);
        }

    }

    public function storeSignature(Request $request)
    {
        $user = auth()->user();
        $userId = $user->id;
        $cid = $user->cid;

        DB::beginTransaction();

        try {
            $workorder = WorkOrder::where('user_cid', $cid)->where('id', $request->input('workorder_id'))->first();

            $sign = SignaturePad::updateOrCreate(
                ['model_id' => $request->input('workorder_id'), 'user_cid' => $cid],
                ['signature' => $request->input('signature'),
                'module' => $request->input('module'),
                'model' => $request->input('model'),
                ]
            );

            // Update the work order with the response start and end time
            WorkOrder::where('id', $workorder->id)
                ->update([
                    'start_time' => $woResponse->start_time,
                    'end_time' => $woResponse->end_time,
                    'status' => $woResponse->status,
                    'work_order_response' => $woResponse->id,
                ]);

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Signature saved or updated successfully']);
        } catch (\Exception $e) {
            // An error occurred, rollback the transaction
            DB::rollback();

            // You can log the error or return an error response
            return response()->json(['error' => 'Error saving Work Order Response'], 500);
        }
    }
}
