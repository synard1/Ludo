<?php

namespace Modules\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Helpdesk\Entities\Ticket;
use Modules\Helpdesk\Entities\WorkOrder;
use Carbon\Carbon;
use Illuminate\Queue\Worker;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = auth()->user();

        if($user){
            // return view('dashboard::index');
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();

        $months = Config::get('onexolution.months');

        $data = Ticket::selectRaw('source_report, AVG(TIMESTAMPDIFF(MINUTE, response_time, report_time)) as avg_time')
            ->whereBetween('response_time', [$firstDayOfMonth, $lastDayOfMonth])
            ->groupBy('source_report')
            ->get();

        $workOrders = WorkOrder::where('user_cid',$user->cid)->get();

            $staffTimes = [];

            foreach ($workOrders as $workOrder) {
                $staff = json_encode($workOrder['staff']);
                $startTime = Carbon::parse($workOrder['start_time']);
                $endTime = Carbon::parse($workOrder['end_time']);
                $timeDiff = $endTime->diffInMinutes($startTime);
    
                if (!isset($staffTimes[$staff])) {
                    $staffTimes[$staff] = [];
                }
    
                $staffTimes[$staff][] = $timeDiff;
            }
    
            $avgTimes = [];
    
            foreach ($staffTimes as $staff => $times) {
                $avgTime = count($times) > 0 ? array_sum($times) / count($times) : 0;
                $avgTimes[] = [
                    'staff' => $staff,
                    'avg_time' => $avgTime,
                ];
            }

        // $data = WorkOrder::selectRaw('staff, AVG(TIMESTAMPDIFF(MINUTE, end_time, start_time)) as avg_time')
        //     ->groupBy('staff')
        //     ->get();

        return view('dashboard::index', compact(['data','months','avgTimes']));
        }else{

        }

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard::create');
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
        return view('dashboard::show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        return view('dashboard::edit');
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

    public function incidentResolutionTimeChart()
    {
        // Fetch data from your database or other sources
        $data = [
            'Critical' => 10,
            'Major' => 15,
            'Minor' => 5,
            // Add more categories and their corresponding resolution times
        ];

        return view('dashboard::charts.incident_resolution_time', compact('data'));
    }

    public function averageTimeBySourceReport()
    {
        $firstDayOfMonth = Carbon::now()->startOfMonth();
        $lastDayOfMonth = Carbon::now()->endOfMonth();

        $months = Config::get('onexolution.months');

        $data = Ticket::selectRaw('source_report, AVG(TIMESTAMPDIFF(MINUTE, response_time, report_time)) as avg_time')
            ->whereBetween('response_time', [$firstDayOfMonth, $lastDayOfMonth])
            ->groupBy('source_report')
            ->get();

        return view('dashboard::charts.average_time_by_source_report', compact(['data','months']));
    }

    public function fetchDataAverageTimeBySourceReport(Request $request)
    {
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');

        $data = DB::table('tickets')
            ->select(DB::raw('source_report, AVG(TIMESTAMPDIFF(MINUTE, report_time, response_time)) as avg_time'))
            ->whereMonth('created_at', '=', $selectedMonth)
            ->whereYear('created_at', '=', $selectedYear)
            ->groupBy('source_report')
            ->get();

        return response()->json($data);
    }

    public function fetchDataAverageTimeByStaff(Request $request)
    {
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');

        $data = DB::table('work_orders')
            ->select(DB::raw('staff, AVG(TIMESTAMPDIFF(MINUTE, end_time, start_time)) as avg_time'))
            ->whereMonth('created_at', '=', $selectedMonth)
            ->whereYear('created_at', '=', $selectedYear)
            ->groupBy('staff')
            ->get();

        return response()->json($data);
    }
}
