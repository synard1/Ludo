<?php

namespace Modules\ITSM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;

use App\Models\Company;
use Modules\ITSM\Entities\WorkOrder;
use Modules\SLA\Entities\SLA;
use Carbon\Carbon;
use Modules\ITSM\Entities\Incident;
use Modules\ITSM\Entities\Service;
use Modules\ITSM\Entities\Reported;
use Modules\ITSM\Http\DataTables\WorkOrderDataTable;

class WorkOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(WorkOrderDataTable $dataTable)
    {
        addVendors(['datatables','tinymce','tempus-dominus']);
        addJavascriptFile('assets/js/custom/apps/itsm/workorder.js');
        
        $user = auth()->user();
        $sla = SLA::where('user_cid',$user->cid)->get();
        $statusWorkOrder = config('itsm.workorder.status');

        // Check if the member level is 'Staff'
        if ($user->level_access === 'Staff' || $user->level_access === 'Supervisor') {
            // Remove 'Cancel' and 'Closed' statuses
            unset($statusWorkOrder['Open'], $statusWorkOrder['Overdue']);
        }

        // $priorities = Config::get('onexolution.priorityWorkOrder');
        // $canCreateWorkorder = auth()->check() && auth()->user()->level_access === 'Supervisor' && $user->can('create itsm-workorder');
        // $services = Service::where('user_cid',$user->cid)->orderBy('name','asc')->get();
        // $incidentCategory = IncidentCategory::where('user_cid',$user->cid)->orderBy('name','asc')->get();
        // // Retrieve distinct staff values from the database
        // $distinctStaff = User::distinct('name')
        //                             ->pluck('name')
        //                             ->where('user_cid',$user->cid)
        //                             ->filter()
        //                             ->map(function ($staff) {
        //                                 return $staff;
        //                             })->flatten()
        //                             ->unique()
        //                             ->values();

        // return view('itsm::incident.index', compact('incidentDataTable', 'categoryDataTable','canCreateIncident','services',));


        return $dataTable->render('itsm::workorder.index',compact(['statusWorkOrder']));
        // return $dataTable->render('helpdesk::service-management.index',compact(['canCreateService','isSupervisor','services']));
        // return view('helpdesk::service-management.index',compact(['canCreateService','isSupervisor']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('itsm::create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = '';
        $user = auth()->user();
        $currentYear = date('Y');

        if($request->input('task') == 'WORK_ORDER_PRINT'){
            $workorder = WorkOrder::where('workorder_number', $request->input('number'))
                                    // ->where('user_cid', $user->cid)
                                    ->first();

            return $this->woPrint($workorder->id);
        }

        $maxNumber = WorkOrder::where('user_cid', $user->cid)->whereYear('created_at', $currentYear)->max('number');
        $prefix = config('itsm.workorder.series');
        $newNumber = $maxNumber+1;
        $formattedNumber = $prefix. $currentYear. str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        $due_date = $request->input('due_date');
        $sla = $request->input('sla');
        $slaData = SLA::where('id',$sla)->first();
        $type = strtolower($request->input('type'));

        if($type == 'incident'){
            $module = 'ITSM/Incident';
            $data = Incident::where('id', $request->input('data_id'))->first();
        }elseif($type == 'service'){
            $module = 'ITSM/Service';
            $data = Service::where('id', $request->input('data_id'))->first();

        }

        // dd($data);

        $workorder = WorkOrder::create([
            'user_id' => $user->id,
            'number' => $newNumber,
            'workorder_number' => $formattedNumber,
            'data_id' => $request->input('data_id'),
            'data_details' => $data->tojson(),
            'supervisor' => $user->name,
            'staff' => $request->input('staff'),
            'location' => $data->reported->location,
            'user' => $data->reported->user,
            'subject' => $data->title,
            'description' => $request->input('description'),
            'status' => 'Open',
            'priority' => $request->input('priority'),
            'module' => $module,
            'sla_id' => $slaData->id ?? '',
            'sla' => $slaData->name ?? '',
            'due_date' => $due_date,
            'report_time' => $data->reported->report_time,
            'response_time' => $data->reported->response_time,
        ]);

        if($sla){
            $slaData = SLA::where('id',$sla)->first();
            // Create a Carbon instance from the original date
            $carbonDate = Carbon::parse($workorder->created_at);

            // Add sla minutes
            $newDate = $carbonDate->addMinutes($slaData->duration);

            WorkOrder::where('id', $workorder->id)
                    ->update(['due_date' => $newDate]);
        }

        if($type == 'incident'){
            Incident::where('id', $request->input('data_id'))
                    ->update(['work_order_id' => $workorder->id]);
        }elseif($type == 'service'){
            Service::where('id', $request->input('data_id'))
                    ->update(['work_order_id' => $workorder->id]);
        }

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

    /**
     * Show the specified resource.
     */
    public function showAjax(Request $request)
    {
        $user = auth()->user();
        // $input = $request->all();

        if($request->input('task') == 'WORK_ORDER_PRINT'){
            $workorder = WorkOrder::where('id', $request->input('number'))
                                    ->where('user_cid', $user->cid)
                                    ->first();

            return $this->woPrint($workorder->id);
        }

        if($request->input('task') == 'WORK_ORDER_RESPONSE'){
            $workorder = WorkOrder::with(['respons' => function ($query) {
                $query->select('id', 'workorder_id', 'status', 'start_time', 'end_time', 'description')
                    ->where('publish', 1)
                    ->take(1);
            }])
            ->where('id', $request->input('id'))
            ->where('user_cid', $user->cid)
            ->select('id', 'module', 'subject', 'report_time', 'response_time')
            ->first();
        }

        
        if($workorder){
            $respons = $workorder->respons->first();
            $result = [
                'id' => $workorder->id,
                'module' => $workorder->module,
                'subject' => $workorder->subject,
                'report_time' => $workorder->report_time,
                'response_time' => $workorder->response_time,
                'respons_id' => optional($respons)->id,
                'workorder_id' => optional($respons)->workorder_id,
                'status' => optional($respons)->status,
                'start_time' => optional($respons)->start_time,
                'end_time' => optional($respons)->end_time,
                'description' => optional($respons)->description,
            ];
            return response()->json($result, 200);
        }else{
            return response()->json($workorder, 404);
        }
        // return view('itsm::show');
    }

    // public function show($id)
    // {
    //     $user = auth()->user();
    //     $workorder = WorkOrder::where('id',$id)
    //                 ->where('user_cid',$user->cid)
    //                 ->first();
    //     if($workorder){
    //         return response()->json($workorder, 200);
    //     }else{
    //         return response()->json($workorder, 404);
    //     }
    //     // return view('itsm::show');
    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('itsm::edit');
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

    public function woPrint($id)
    {
        $user = auth()->user();

        $workorder = WorkOrder::where('id',$id)->first();
        $company = Company::where('cid',$user->cid)->first();
        
        // $ticket = Ticket::where('work_order_id',$id)->first();
        $module = strtolower($workorder->module);

        $ticket = '';
        $woNotes = '';
        $woResponse = '';

        if (Str::contains($module, 'incident')) {
            $data = Incident::where('id',$workorder->data_id)->first();
            // dd($data);
            $reporteds = Reported::where('data_id',$data->id)->first();
            // The string contains 'incident'
            // echo "String contains 'incident'";
        } else if (Str::contains($module, 'service')) {
            $data = Service::where('id',$workorder->data_id)->first();
            // dd($data);
            $reporteds = Reported::where('data_id',$data->id)->first();
            // dd($module);
            // The string does not contain 'incident'
            // echo "String does not contain 'incident'";
        }
        // return view('itsm::workorder._print3', compact(['workorder','company','woResponse','woNotes','data','reporteds']));

        // Use the view function to get the view result
        // $viewResult = view('itsm::workorder._print3', compact('workorder', 'company', 'woResponse', 'woNotes', 'data', 'reporteds'));
        // Now you can return or further manipulate the $viewResult if needed
        // return $viewResult;

        $htmlContent = view('itsm::workorder._print3', compact('workorder', 'company', 'woResponse', 'woNotes', 'data', 'reporteds'))->render();

        // Specify the directory path where you want to save the HTML
        $directoryPath = storage_path('app/public/print/');

        // Create the directory if it doesn't exist
        File::makeDirectory($directoryPath, 0755, true, true);

        // Specify the file path
        $filePath = $directoryPath . 'WorkOrder_'.$workorder->workorder_number.'.html';

        // Delete the file if it already exists
        if (File::exists($filePath)) {
            File::delete($filePath);
        }

        // Save the HTML content to the file
        File::put($filePath, $htmlContent);

        // Specify the file path where you want to save the HTML
        // $filePath = storage_path('app/public/print/WorkOrder_'.$id.'.html');

        // Save the HTML content to the file
        File::put($filePath, $htmlContent);

        return '1';

        
    }

    public function storeResponse(Request $request)
    {
        $user = auth()->user();

        // Start a database transaction
        DB::beginTransaction();

        try {
            $workorder = WorkOrder::where('user_cid', $user->cid)->where('id', $request->input('workorder_id'))->first();
            $ticket = Ticket::where('work_order_id', $request->input('workorder_id'))->first();

            $woResponse = WorkOrderResponse::updateOrCreate(
                ['work_order_id' => $request->input('workorder_id'), 'user_cid' => $user->cid],
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

            // if($woResponse->isDirty('status')){
            //     $statusHistory = StatusHistory::create([
            //         'data_id' => $ticket->id,
            //         'name' => Uc($ticket->subject),
            //         'module' => 'Helpdesk',
            //         'model' => 'WorkOrder',
            //         'old_status' => $ticket->status,
            //         'new_status' => $request->input('status'),
            //         'status' => $request->input('status'),
            //         'reason' => 'Update WO Response',
            //     ]);
            // }

            // Update the work order with the response start and end time
            // WorkOrder::where('id', $workorder->id)
            //     ->update([
            //         'start_time' => $woResponse->start_time,
            //         'end_time' => $woResponse->end_time,
            //         'status' => $woResponse->status,
            //         'work_order_response' => $woResponse->id,
            //     ]);

            // Update the ticket with the new status
            // Ticket::where('id', $ticket->id)
            //         ->update([
            //             'status' => $request->input('status'),
            //         ]);

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

    public function printWorkOrder($filename)
    {
        $filePath = storage_path("app/public/print/{$filename}");

        if (file_exists($filePath)) {
            // You can add additional headers or modify the response as needed
            return response()->file($filePath);
        }else{

            return 'aa';
        }

        // Handle the case where the file doesn't exist
        abort(404);
    }
}