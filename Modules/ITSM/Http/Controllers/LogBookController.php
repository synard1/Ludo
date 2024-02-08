<?php

namespace Modules\ITSM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\ITSM\Http\DataTables\LogBookDataTable;

use Modules\ITSM\Entities\LogBook;

use Carbon\Carbon;

class LogBookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(LogBookDataTable $dataTable)
    {
        addVendors(['datatables','tinymce','tempus-dominus']);
        addJavascriptFile('assets/js/custom/apps/itsm/logbook.js');
        
        $user = auth()->user();
        $canCreateLogbook = auth()->check() && $user->can('create itsm-logbook');
        $isSupervisor = auth()->check() && auth()->user()->level_access === 'Supervisor';
        $status = config('itsm.logbook.status');

        // return view('itsm::logbook.index', compact(['canCreateLogbook']));
        return $dataTable->render('itsm::logbook.index',compact(['canCreateLogbook','status','isSupervisor']));

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
        $input = $request->all();

        // dd($input);

        // Start a database transaction
        DB::beginTransaction();

        try {

            if($request->input('id')){
                $lastData = LogBook::where('id', $request->input('id'))
                    ->first();

                if($lastData){
                    LogBook::where('id', $lastData->id)
                            ->update(['publish' => 0]);
                }

                $logbookData = [
                    'parent_id' => $lastData->parent_id,
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'start_time' => $request->input('start_time'),
                    'end_time' => $request->input('end_time'),
                    'publish' => '1',
                ];
                
                // Check if $request contains 'status' and it's different from 'Needs Review'
                if ($request->has('status') && $request->input('status') !== $lastData->status) {
                    $logbookData['status'] = $request->input('status');
                }

                // Check if $request contains 'status' and it's different from 'Needs Review'
                if (auth()->user()->level_access === 'Staff' && auth()->user()->id === $lastData->user_id) {
                    $logbookData['status'] = 'Needs Review';

                    LogBook::where('id', $request->input('id'))
                            ->update([
                                'publish' => 0,
                            ]);
                }

                // Check if $request contains 'status' and it's different from 'Needs Review'
                if (auth()->user()->level_access === 'Supervisor' && auth()->user()->id !== $lastData->user_id) {
                    // dd($lastData->user_id . ' ' . auth()->user()->id);
                    $logbookData['approved_cid'] = $user->cid;
                    $logbookData['approved_id'] = $user->id;
                    $logbookData['approved_by'] = $user->name;
                    $logbookData['approved_by_level'] = $user->level_access;
                    $logbookData['approved_time'] = Carbon::now();
                }

                // Create or update LogBook record
                $logbook = LogBook::create($logbookData);

                // dd($logbook);

                // Check if $request contains 'status' and it's different from 'Needs Review'
                if (auth()->user()->level_access === 'Supervisor' && auth()->user()->id !== $lastData->user_id) {
                    LogBook::where('id', $logbook->id)
                            ->update([
                                // 'approved_cid' => $user->user_cid,
                                // 'approved_id' => $user->user_id,
                                // 'approved_by' => $user->created_by,
                                // 'approved_by_level' => $user->created_by_level,
                                // 'approved_time' => Carbon::now(),
                                'user_id' => $lastData->user_id,
                                'user_cid' => $lastData->user_cid,
                                'created_by' => $lastData->created_by,
                                'created_by_level' => $lastData->created_by_level,
                            ]);
                }

            }else{
                $logbook = LogBook::create([
                    'parent_id' => null,
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'start_time' => $request->input('start_time'),
                    'end_time' => $request->input('end_time'),
                    'status' => 'Needs Review',
                    'publish' => '1',
                ]);

                LogBook::where('id', $logbook->id)
                            ->update([
                                'parent_id' => $logbook->id,
                            ]);

            }

            // Commit the transaction
            DB::commit();

            // You can return a response, e.g., a success message
            return response()->json(['message' => 'Logbook saved or updated successfully']);
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
            $logbook = LogBook::where('id', $request->input('id'))->first();
            $data = [
                'id' => $logbook->id,
                'title' => $logbook->title,
                'description' => $logbook->description,
                'start_time' => $logbook->start_time,
                'end_time' => $logbook->end_time,
                'status' => $logbook->status,
            ];

            session(['mode' => 'edit']);
            return response()->json(['data' => $data]);
        } else {
            // Service not found
            return response()->json(['data' => '']);
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
        //
    }

    public function deleteAjax(Request $request)
    {
        // Assuming you have an authenticated user
        $user = auth()->user();

        // Check if the user has permission to delete service
        if ($user->can('delete itsm-logbook')) {
            try {
                if($request->input('task') == 'DELETE_LOGBOOK'){
                    // Find the service by UUID
                    $logbook = LogBook::where('id', $request->input('id'))->firstOrFail();

                    // Delete the service
                    $logbook->delete();

                    // You can return a success message or redirect back
                    return response()->json(['message' => 'Logbook deleted successfully']);
                }
                
            } catch (\Exception $e) {
                // Handle any exceptions that occur during deletion
                return response()->json(['message' => 'An error occurred during logbook deletion'], 500);
            }
        } else {
            // If the user doesn't have permission, return a forbidden response
            return response()->json(['message' => 'Forbidden'], 403);
        }
    }
}
