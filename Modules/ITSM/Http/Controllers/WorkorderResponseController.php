<?php

namespace Modules\ITSM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

use Modules\ITSM\Entities\WorkOrder;
use Modules\ITSM\Entities\WorkorderResponse;
use Modules\ITSM\Entities\Incident;

class WorkorderResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('itsm::index');
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
    // public function store(Request $request)
    // {
    //     // Get the last data ID
    //     $lastDataId = WorkorderResponse::latest()->value('id');
    //     $module = strtolower($request->input('module'));
    //     $status = $request->input('status');

    //     // Start a database transaction
    //     DB::beginTransaction();

    //     try {
    //         if($lastDataId){
    //             $response = WorkorderResponse::where('id', $lastDataId)
    //                     ->update(['publish' => 0]);
    //         }
            
    //         $workorder = WorkOrder::where('id', $request->input('workorder_id'))
    //                     ->update(['status' => $status]);

    //         if (Str::contains($module, 'incident')) {
    //             $data = Incident::where('id', $workorder->data_id)
    //                     ->update(['status' => $status]);
    //         }

    //         $woResponse = WorkorderResponse::create($request->all());

    //         // Commit the transaction
    //         DB::commit();

    //         return response()->json(['message' => 'Work Order Response saved or updated successfully'], 201);
    //         // return response()->json($woResponse, 201);
            
    //     } catch (\Throwable $th) {
    //         // An error occurred, rollback the transaction
    //         DB::rollback();

    //         // You can log the error or return an error response
    //         return response()->json(['error' => 'Error saving Work Order Response'], 500);
    //     }
        
    // }
    public function store(Request $request)
{
    // Get the last data ID
    $lastDataId = WorkorderResponse::latest()->value('id');
    $module = strtolower($request->input('module'));
    $status = $request->input('status');

    // Start a database transaction
    DB::beginTransaction();

    try {
        if ($lastDataId) {
            $response = WorkorderResponse::where('id', $lastDataId)
                ->update(['publish' => 0]);
        }

        $workorder = WorkOrder::where('id', $request->input('workorder_id'))->first();

        WorkOrder::where('id', $request->input('workorder_id'))
            ->update(['status' => $status]);

        if (Str::contains($module, 'incident')) {
            $data = Incident::where('id', $workorder->data_id)
                ->update(['status' => $status]);
        }

        $woResponse = WorkorderResponse::create($request->all());

        // Commit the transaction
        DB::commit();

        return response()->json(['message' => 'Work Order Response saved or updated successfully'], 201);
        // return response()->json($woResponse, 201);

    } catch (\Throwable $th) {
        // An error occurred, rollback the transaction
        DB::rollback();

        // Log the error
        Log::error('Error saving Work Order Response: ' . $th->getMessage());

        // Return an error response with the error message
        return response()->json(['error' => 'Error saving Work Order Response. ' . $th->getMessage()], 500);
    }
}

    /**
     * Show the specified resource.
     */
    public function show($id)
    {
        $user = auth()->user();
        $woResponse = WorkorderResponse::where('workorder_id',$id)
                    ->where('publish',1)
                    ->where('user_cid',$user->cid)
                    ->first();
        if($woResponse){
            return response()->json($woResponse, 200);
        }else{
            return response()->json($woResponse, 404);
        }
        
        // return view('itsm::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = auth()->user();
        $woResponse = WorkorderResponse::where('workorder_id',$id)
                    ->where('publish',1)
                    ->where('user_cid',$user->cid)
                    ->first();
        if($woResponse){
            return response()->json($woResponse, 200);
        }else{
            return response()->json($woResponse, 404);
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
        //
    }
}
