<?php

namespace Modules\ITSM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;

use Modules\ITSM\Http\DataTables\IncidentDataTable;
use Modules\ITSM\Http\DataTables\IncidentCategoryDataTable;
use Modules\Helpdesk\Entities\Service;
use Modules\ITSM\Entities\Incident;
use Modules\ITSM\Entities\IncidentCategory;
use Modules\ITSM\Entities\Reported;
use App\Models\User;
use Modules\SLA\Entities\SLA;

class IncidentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexTest()
    {
        return view('itsm::incident.index');
    }

    public function index(IncidentDataTable $dataTable, IncidentCategoryDataTable $categoryDataTable)
    {
        addVendors(['datatables','tinymce']);
        addJavascriptFile('assets/js/custom/apps/itsm/incident.js');
        // addJavascriptFile('assets/js/custom/apps/itsm/workorder.js');
        
        $user = auth()->user();
        $sla = SLA::where('user_cid',$user->cid)->get();
        $priorities = config('itsm.workorder.priority');
        $canCreateIncident = auth()->check() && auth()->user()->level_access === 'Supervisor' && $user->can('create itsm-incident');
        $canCreateIncidentCategory = auth()->check() && auth()->user()->level_access === 'Supervisor' && $user->can('create itsm-incident-category');
        $services = Service::where('user_cid',$user->cid)->orderBy('name','asc')->get();
        $incidentCategory = IncidentCategory::where('user_cid',$user->cid)->orderBy('name','asc')->get();
        // Retrieve distinct staff values from the database
        $distinctStaff = User::distinct('name')
                                    ->pluck('name')
                                    ->where('user_cid',$user->cid)
                                    ->filter()
                                    ->map(function ($staff) {
                                        return $staff;
                                    })->flatten()
                                    ->unique()
                                    ->values();

        // return view('itsm::incident.index', compact('incidentDataTable', 'categoryDataTable','canCreateIncident','services',));


        return $dataTable->render('itsm::incident.index',compact(['canCreateIncident','services','incidentCategory', 'distinctStaff', 'sla', 'priorities','canCreateIncidentCategory']));
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
        $user = auth()->user();
        $currentYear = date('Y');
        $maxNumber = Incident::where('user_cid', $user->cid)->whereYear('created_at', $currentYear)->max('number');
        $newNumber = $maxNumber + 1;
        $formattedNumber = 'INC'. $currentYear. str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        
        $incidentCategory = IncidentCategory::where('user_cid', $user->cid)
                            ->where('id', $request->input('classification'))
                            ->first(); // Use 'first' to get a single result or null if not found

        // dd($incidentCategory);

        // $reported = Reported::create([
        //     'user' => $request->input('reportedBy'),
        //     'location' => $request->input('location'),
        //     'source' => $request->input('source'),
        //     'report_time' => $request->input('report_time'),
        //     'response_time' => $request->input('response_time'),
        //     'category' => $request->input('category')
        // ]);

        // $incident = Incident::create([
        //     'category_id' => $incidentCategory->id,
        //     'category_name' => $incidentCategory->name,
        //     'incident_number' => $formattedNumber,
        //     'number' => $newNumber,
        //     'title' => Uc($request->input('incident')),
        //     'description' => $request->input('description'),
        //     'severity' => $request->input('severity'),
        //     'kpi' => $request->input('kpi'),
        //     'status' => 'Open',
        //     'reported_id' => $reported->id,
        //     'reported_by' => $reported->user,
        //     'reported_location' => $reported->location,
        //     'reported_source' => $reported->source,
        //     'reported_category' => $reported->category,
        //     'reported_date' => $reported->report_time,
        //     'reported_response' => $reported->response_time,
        // ]);

        // dd($incident);

        // Start a database transaction
        DB::beginTransaction();

        try {

            if($request->input('incident_id')){
                // Update the incident with the new data
                $reported = Reported::where('data_id', $request->input('incident_id'))
                        ->update([
                    'user' => $request->input('reportedBy'),
                    'location' => $request->input('location'),
                    'source' => $request->input('source'),
                    'report_time' => $request->input('report_time'),
                    'response_time' => $request->input('response_time'),
                    'category' => $request->input('category')
                ]);

                $incident = Incident::where('id', $request->input('incident_id'))
                ->update([
                    'category_id' => $incidentCategory->id,
                    'category_name' => $incidentCategory->name,
                    'description' => $request->input('description'),
                    'severity' => $request->input('severity'),
                    'kpi' => $request->input('kpi'),
                    // 'status' => 'Open',
                ]);

            }else{
                $reported = Reported::create([
                    'user' => $request->input('reportedBy'),
                    'location' => $request->input('location'),
                    'source' => $request->input('source'),
                    'report_time' => $request->input('report_time'),
                    'response_time' => $request->input('response_time'),
                    'category' => $request->input('category')
                ]);

                $incident = Incident::create([
                    'category_id' => $incidentCategory->id,
                    'category_name' => $incidentCategory->name,
                    'incident_number' => $formattedNumber,
                    'number' => $newNumber,
                    'title' => Uc($request->input('incident')),
                    'description' => $request->input('description'),
                    'severity' => $request->input('severity'),
                    'kpi' => $request->input('kpi'),
                    'status' => 'Open',
                    'reported_id' => $reported->id,
                    // 'reported_by' => $reported->user,
                    // 'reported_location' => $reported->location,
                    // 'reported_source' => $reported->source,
                    // 'reported_category' => $reported->category,
                    // 'reported_date' => $reported->report_time,
                    // 'reported_response' => $reported->response_time,
                ]);

                // Update the incident with the new status
                Reported::where('id', $reported->id)
                        ->update([
                            'data_id' => $incident->id,
                            'data_module' => 'ITSM\Incident',
                            'data_number' => $incident->incident_number,
                        ]);

            }

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Incident saved or updated successfully']);
        } catch (\Throwable $th) {
            // An error occurred, rollback the transaction
            DB::rollback();

            //throw $th;
            return response()->json(['message' => 'Failed']);
        }

    }

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        return view('itsm::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    // public function edit($id, Request $request)
    public function edit(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID

        // dd($request->all());

        // if($id){
        //     $incident = Incident::where('id', $id)->first();
        //     return response()->json(['data' => $incident]);
        // }
        if($request->input('id')){
            $incident = Incident::where('id', $request->input('id'))->first();
            $data = [
                'id' => $incident->id,
                'category_id' => $incident->incidentCategory->id,
                'title' => $incident->title,
                'description' => $incident->description,
                'severity' => $incident->severity,
                'reportedBy' => $incident->reported->user,
                'location' => $incident->reported->location,
                'source' => $incident->reported->source,
                'report_time' => $incident->reported->report_time,
                'response_time' => $incident->reported->response_time,
                'category' => $incident->reported->category,
            ];
            // $formattedIncidents = $incidents->map(function ($incident) {
            //     return [
            //         'incident' => $incident->title,
            //         'description' => $incident->description,
            //         'location' => $incident->reported->location,
            //         'source' => $incident->reported->source,
            //         'category' => $incident->reported->category,
            //         // Add other attributes as needed
            //     ];
            // });
            return response()->json(['data' => $data]);
        }

        // Retrieve the incident data based on user_id and cid
        $incidents = Incident::where('user_cid', $user->cid)->orderBy('created_at','desc')
            ->get(); // Use 'first' to get a single result or null if not found

        if ($incidents->isNotEmpty()) {
            // Transform the incident data to include user names
            $formattedIncidents = $incidents->map(function ($incident) {
                return [
                    'id' => $incident->id,
                    'user_name' => $incident->user->name,
                    'cid' => $incident->user_cid,
                    'subject' => $incident->subject,
                    'description' => $incident->description,
                    'origin_unit' => $incident->origin_unit,
                    'priority' => $incident->priority,
                    'source_report' => $incident->source_report,
                    'work_order' => $incident->work_order_id,
                    'issue_category' => $incident->issue_category,
                    'status' => $incident->status,
                    'created_at' => $incident->created_at,
                    'actionButtons' => $this->getActionButtons($incident)
                    // Add other attributes as needed
                ];
            });

                return response()->json(['data' => $formattedIncidents]);
        } else {
            // Incident not found
            return response()->json(['data' => '']);
            // return response()->json(['message' => 'Incident not found'], 404);
        }
        // return view('itsm::edit');
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
        // Assuming you have an authenticated user
        $user = auth()->user();

        // Check if the user has permission to delete incident
        if ($user->can('delete itsm-incident')) {
            try {
                // Find the incident by UUID
                $incident = Incident::where('id', $id)->firstOrFail();

                // Check if the incident has associated work orders
                if ($incident->workorder()->exists()) {
                    // If there are associated work orders, show a warning
                    return response()->json(['message' => 'Incident has associated work orders and cannot be deleted'], 400);
                }

                // Delete the incident
                $incident->delete();

                // Delete the incident report user
                $incidentReport = Reported::where('data_id', $id)->firstOrFail();
                $incidentReport->delete();

                // You can return a success message or redirect back
                return response()->json(['message' => 'Incident deleted successfully']);
            } catch (\Exception $e) {
                // Handle any exceptions that occur during deletion
                return response()->json(['message' => 'An error occurred during incident deletion'], 500);
            }
        } else {
            // If the user doesn't have permission, return a forbidden response
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }

    public function getAjax(Request $request)
    {
        $user = auth()->user();

        if($request->input('task') == 'GET_INCIDENT_CATEGORY'){
            if($request->input('id') != null ){
                $incidentCategory = IncidentCategory::where('user_cid', $user->cid)
                                    ->where('id',$request->input('id'))
                                    ->first();
                                    // ->select(['id','name','description','created_at']);
                // dd($incidentCategory);
                // return response()->json(['data' => $incidentCategory]);
                return response()->json($incidentCategory, 200);
            }else{
                $incidentCategory = IncidentCategory::where('user_cid', $user->cid)
                                    ->select(['id','name','description','created_at']);

            // return datatables()->of($incidentCategory)->toJson();
            return datatables()->of($incidentCategory)
            ->addColumn('action', function ($incidentCategory) {
                return view('itsm::incident._actionCategory', compact('incidentCategory'));
            })
            ->toJson();

            }
            
        }
    }


    public function postAjax(Request $request)
    {
        $user = auth()->user();

        if($request->input('task') == 'SAVE_CATEGORY'){
            if($request->input('id') != null ){
                IncidentCategory::where('id', $request->input('id'))
                                    ->update([
                                        'name' => $request->input('name'),
                                        'description' => $request->input('description')
                                    ]);
                return response()->json(['message' => 'Category saved or updated successfully'], 201);
            }else{
                IncidentCategory::create([
                    'name' => $request->input('name'),
                    'description' => $request->input('description'),
                ]);
                // You can return a success message or redirect back
                return response()->json(['message' => 'Category create successfully'], 201);
            }
            
        }
    }

    public function deleteAjax(Request $request)
    {
        // Assuming you have an authenticated user
        $user = auth()->user();

        // Check if the user has permission to delete incident
        if ($user->can('delete itsm-incident-category')) {
            try {
                if($request->input('task') == 'DELETE_CATEGORY'){
                    // Find the incident by UUID
                    $category = IncidentCategory::where('id', $request->input('id'))->firstOrFail();

                    // Check if the incident has associated work orders
                    if ($category->incident()->exists()) {
                        // If there are associated work orders, show a warning
                        return response()->json(['message' => 'Category has associated data and cannot be deleted'], 400);
                    }

                    // Delete the incident
                    $category->delete();

                    // You can return a success message or redirect back
                    return response()->json(['message' => 'Category deleted successfully']);
                }
                

                
            } catch (\Exception $e) {
                // Handle any exceptions that occur during deletion
                return response()->json(['message' => 'An error occurred during category deletion'], 500);
            }
        } else {
            // If the user doesn't have permission, return a forbidden response
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }
}
