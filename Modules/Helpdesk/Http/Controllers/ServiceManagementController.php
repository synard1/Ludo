<?php

namespace Modules\Helpdesk\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

use Modules\Helpdesk\Http\DataTables\ServiceManagementDataTable;
use Modules\Helpdesk\Http\DataTables\ServiceRequestDataTable;
use Modules\Helpdesk\Entities\Service;

class ServiceManagementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(ServiceManagementDataTable $dataTable)
    {
        addVendors(['datatables','tinymce']);
        addJavascriptFile('assets/js/custom/apps/helpdesk/service.js');
        
        $user = auth()->user();
        $canCreateService = auth()->check() && auth()->user()->level_access === 'Owner' && $user->can('create service management');
        $services = Service::where('user_cid',$user->cid)->orderBy('name','asc')->get();
        

        return $dataTable->render('helpdesk::service-management.index',compact(['canCreateService','services']));
        // return $dataTable->render('helpdesk::service-management.index',compact(['canCreateService','isSupervisor','services']));
        // return view('helpdesk::service-management.index',compact(['canCreateService','isSupervisor']));
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
    public function store(Request $request)
    {
        $user = auth()->user();
        // Retrieve the ticket data based on user_id and cid
        // $service = Service::where('user_cid', $user->cid)->where('id', $request->input('service_id'))->first(); // Use 'first' to get a single result or null if not found

        // Start a database transaction
        DB::beginTransaction();

        try {
            if($request->input('service_id')){
                // Update the ticket with the new status
                Service::where('id', $request->input('service_id'))
                        ->update([
                            'description' => $request->input('description'),
                        ]);

            }else{
                $service = Service::create([
                    'name' => $request->input('service'),
                    'description' => $request->input('description'),
                ]);

            }

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Service save successfully']);
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

    public function getServiceData(Request $request)
    {
        $user = auth()->user(); // Get the authenticated user's ID
        $cid = $user->cid; // Assuming 'cid' is provided in the request

        if($request->input('service_id')){
            $service = Service::where('id', $request->input('service_id'))->first();
            return response()->json(['data' => $service]);
        }

        // Retrieve the service data based on user_id and cid
        $services = Service::where('user_cid', $cid)->orderBy('created_at','desc')
            ->get(); // Use 'first' to get a single result or null if not found

        if ($services->isNotEmpty()) {
            // Transform the service data to include user names
            $formattedServices = $services->map(function ($service) {
                return [
                    'id' => $service->id,
                    'name' => $service->name,
                    'description' => $service->description,
                    'created_at' => $service->created_at,
                    // 'actionButtons' => $this->getActionButtons($service)
                    // Add other attributes as needed
                ];
            });

                return response()->json(['data' => $formattedServices]);
        } else {
            // Ticket not found
            return response()->json(['data' => '']);
            // return response()->json(['message' => 'Ticket not found'], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function deleteService($id)
    {
        // Assuming you have an authenticated user
        $user = auth()->user();

        // Check if the user has permission to delete services
        if ($user->can('delete service management')) {
            try {
                // Find the service by ID
                // $service = Service::findOrFail($id);

                // Find the service by UUID
                $service = Service::where('id', $id)->firstOrFail();

                // Check if the service has associated work orders
                if ($service->tickets()->exists()) {
                    // If there are associated work orders, show a warning
                    return response()->json(['message' => 'Service has associated ticket and cannot be deleted'], 400);
                }

                // Delete the service
                $service->delete();

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
}
