<?php

namespace Modules\ITSM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use App\Models\User;
use Modules\SLA\Entities\SLA;
use Modules\ITSM\Entities\Reported;
use Modules\ITSM\Entities\ServiceCategory;
use Modules\ITSM\Entities\Service;

use Modules\ITSM\Http\DataTables\ServiceDataTable;

class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceDataTable $dataTable)
    {
        addVendors(['datatables','tinymce']);
        addJavascriptFile('assets/js/custom/apps/itsm/service.js');
        // addJavascriptFile('assets/js/custom/apps/itsm/workorder.js');
        
        $user = auth()->user();
        $sla = SLA::where('user_cid',$user->cid)->get();
        $priorities = config('itsm.workorder.priority');
        $canCreateService = auth()->check() && auth()->user()->level_access === 'Supervisor' && $user->can('create itsm-service');
        $canCreateServiceCategory = auth()->check() && auth()->user()->level_access === 'Supervisor' && $user->can('create itsm-service-category');
        $services = Service::where('user_cid',$user->cid)->orderBy('title','asc')->get();
        $serviceCategory = ServiceCategory::where('user_cid',$user->cid)->orderBy('name','asc')->get();
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

        return $dataTable->render('itsm::service.index',compact(['canCreateService','services','serviceCategory', 'distinctStaff', 'sla', 'priorities','canCreateServiceCategory']));
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
        $maxNumber = Service::where('user_cid', $user->cid)->whereYear('created_at', $currentYear)->max('number');
        $newNumber = $maxNumber + 1;
        $formattedNumber = 'SVC'. $currentYear. str_pad($newNumber, 3, '0', STR_PAD_LEFT);
        
        $serviceCategory = ServiceCategory::where('user_cid', $user->cid)
                            ->where('id', $request->input('classification'))
                            ->first(); // Use 'first' to get a single result or null if not found


        // Start a database transaction
        DB::beginTransaction();

        try {

            if($request->input('service_id')){
                // Update the service with the new data
                $reported = Reported::where('data_id', $request->input('service_id'))
                        ->update([
                    'user' => $request->input('reportedBy'),
                    'location' => $request->input('location'),
                    'source' => $request->input('source'),
                    'report_time' => $request->input('report_time'),
                    'response_time' => $request->input('response_time'),
                    'category' => $request->input('category')
                ]);

                $service = Service::where('id', $request->input('service_id'))
                ->update([
                    'category_id' => $serviceCategory->id,
                    'category_name' => $serviceCategory->name,
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

                $service = Service::create([
                    'category_id' => $serviceCategory->id,
                    'category_name' => $serviceCategory->name,
                    'service_number' => $formattedNumber,
                    'number' => $newNumber,
                    'title' => Uc($request->input('service')),
                    'description' => $request->input('description'),
                    'severity' => $request->input('severity'),
                    'kpi' => $request->input('kpi'),
                    'status' => 'Open',
                    'reported_id' => $reported->id,
                ]);

                // Update the service with the new status
                Reported::where('id', $reported->id)
                        ->update([
                            'data_id' => $service->id,
                            'data_module' => 'ITSM\Service',
                            'data_number' => $service->service_number,
                        ]);

            }

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Service saved or updated successfully']);
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
    public function edit(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID
        if($request->input('id')){
            $service = Service::where('id', $request->input('id'))->first();
            $data = [
                'id' => $service->id,
                'category_id' => $service->serviceCategory->id,
                'title' => $service->title,
                'description' => $service->description,
                'reportedBy' => $service->reported->user,
                'location' => $service->reported->location,
                'source' => $service->reported->source,
                'report_time' => $service->reported->report_time,
                'response_time' => $service->reported->response_time,
                'category' => $service->reported->category,
            ];

            return response()->json(['data' => $data]);
        }

        // Retrieve the service data based on user_id and cid
        $services = Service::where('user_cid', $user->cid)->orderBy('created_at','desc')
            ->get(); // Use 'first' to get a single result or null if not found

        if ($services->isNotEmpty()) {
            // Transform the service data to include user names
            $formattedServices = $services->map(function ($service) {
                return [
                    'id' => $service->id,
                    'user_name' => $service->user->name,
                    'cid' => $service->user_cid,
                    'subject' => $service->subject,
                    'description' => $service->description,
                    'origin_unit' => $service->origin_unit,
                    'priority' => $service->priority,
                    'source_report' => $service->source_report,
                    'work_order' => $service->work_order_id,
                    'issue_category' => $service->issue_category,
                    'status' => $service->status,
                    'created_at' => $service->created_at,
                    'actionButtons' => $this->getActionButtons($service)
                    // Add other attributes as needed
                ];
            });

                return response()->json(['data' => $formattedServices]);
        } else {
            // Service not found
            return response()->json(['data' => '']);
            // return response()->json(['message' => 'Service not found'], 404);
        }
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

        // Check if the user has permission to delete service
        if ($user->can('delete itsm-service')) {
            try {
                // Find the service by UUID
                $service = Service::where('id', $id)->firstOrFail();

                // Check if the service has associated work orders
                if ($service->workorder()->exists()) {
                    // If there are associated work orders, show a warning
                    return response()->json(['message' => 'Service has associated work orders and cannot be deleted'], 400);
                }

                // Delete the service
                $service->delete();

                // Delete the service report user
                $serviceReport = Reported::where('data_id', $id)->firstOrFail();
                $serviceReport->delete();

                // You can return a success message or redirect back
                return response()->json(['message' => 'Service deleted successfully']);
            } catch (\Exception $e) {
                // Handle any exceptions that occur during deletion
                return response()->json(['message' => 'An error occurred during service deletion'], 500);
            }
        } else {
            // If the user doesn't have permission, return a forbidden response
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }

    public function getAjax(Request $request)
    {
        $user = auth()->user();

        if($request->input('task') == 'GET_SERVICE_CATEGORY'){
            if($request->input('id') != null ){
                $serviceCategory = ServiceCategory::where('user_cid', $user->cid)
                                    ->where('id',$request->input('id'))
                                    ->first();
                                    // ->select(['id','name','description','created_at']);
                // return response()->json(['data' => $serviceCategory]);
                return response()->json($serviceCategory, 200);
            }else{
                $serviceCategory = ServiceCategory::where('user_cid', $user->cid)
                                    ->select(['id','name','description','created_at']);

            // return datatables()->of($serviceCategory)->toJson();
            return datatables()->of($serviceCategory)
            ->addColumn('action', function ($serviceCategory) {
                return view('itsm::service._actionCategory', compact('serviceCategory'));
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
                ServiceCategory::where('id', $request->input('id'))
                                    ->update([
                                        'name' => $request->input('name'),
                                        'description' => $request->input('description')
                                    ]);
                return response()->json(['message' => 'Category saved or updated successfully'], 201);
            }else{
                ServiceCategory::create([
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

        // Check if the user has permission to delete service
        if ($user->can('delete itsm-service-category')) {
            try {
                if($request->input('task') == 'DELETE_CATEGORY'){
                    // Find the service by UUID
                    $category = ServiceCategory::where('id', $request->input('id'))->firstOrFail();

                    // Check if the service has associated work orders
                    if ($category->service()->exists()) {
                        // If there are associated work orders, show a warning
                        return response()->json(['message' => 'Category has associated data and cannot be deleted'], 400);
                    }

                    // Delete the service
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
