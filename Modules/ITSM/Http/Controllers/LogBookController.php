<?php

namespace Modules\ITSM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Modules\ITSM\Http\DataTables\LogBookDataTable;

use Modules\ITSM\Entities\LogBook;

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

        // return view('itsm::logbook.index', compact(['canCreateLogbook']));
        return $dataTable->render('itsm::logbook.index',compact(['canCreateLogbook']));

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
                $lastDataId = LogBook::where('id', $request->input('id'))
                    ->latest()
                    ->value('id');

                if($lastDataId){
                    LogBook::where('id', $lastDataId)
                            ->update(['publish' => 0]);
                }

                $logbook = LogBook::create([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'start_time' => $request->input('start_time'),
                    'end_time' => $request->input('end_time'),
                    'status' => 'Needs Review',
                    'publish' => '1',
                ]);

            }else{
                $logbook = LogBook::create([
                    'title' => $request->input('title'),
                    'description' => $request->input('description'),
                    'start_time' => $request->input('start_time'),
                    'end_time' => $request->input('end_time'),
                    'status' => 'Needs Review',
                    'publish' => '1',
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
            ];

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
}
