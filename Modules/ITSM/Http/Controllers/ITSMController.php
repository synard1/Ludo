<?php

namespace Modules\ITSM\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

use Modules\ITSM\Entities\Incident;
use Modules\ITSM\Entities\WorkorderResponse;
use Modules\ITSM\Entities\WorkOrder;

class ITSMController extends Controller
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
    public function store(Request $request): RedirectResponse
    {
        //
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

    public function fixData()
    {
        $selectedMonth = '02';
        $selectedYear = '2024';

        try {
            // $response = WorkorderResponse::where('status', 'Completed')
            //     ->whereMonth('start_time', '=', $selectedMonth)
            //     ->whereYear('start_time', '=', $selectedYear)
            //     ->whereNull('start_time')
            //     ->get();

            $response = WorkOrder::where('status', 'Completed')
                ->whereMonth('report_time', '=', $selectedMonth)
                ->whereYear('report_time', '=', $selectedYear)
                ->whereNull('start_time')
                ->get();

        foreach ($response as $r) {
            $ro = WorkorderResponse::where('status', 'Completed')
                ->where('workorder_id', $r->id)
                ->first();

            $wo = WorkOrder::where('id', $r->id)
            ->update(['start_time' => $ro->start_time,'end_time' => $ro->end_time]);

            
        }

        return response()->json(['message' => 'Data Fix Successfully' . now()]);

        } catch (\Throwable $th) {
            return response()->json(['message' => 'Failed' . $th]);
        }

    }
}
