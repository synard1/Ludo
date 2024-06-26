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
use DatePeriod;
use DateTime;
use DateInterval;

use App\Models\Company;

use Modules\ITSM\Entities\Service;
use Modules\ITSM\Entities\Incident;
use Modules\ITSM\Entities\WorkOrder as EntitiesWorkOrder;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexReport()
    {
        $user = auth()->user();
        $company = Company::where('cid', $user->cid)->first();

        if ($user) {
            $firstDayOfMonth = Carbon::now()->startOfMonth();
            $lastDayOfMonth = Carbon::now()->endOfMonth();

            // Split Env local data
            if (isLocal()) {
                // Code for local environment
                $workOrders = WorkOrder::where('status', 'Resolved')->get();
                $tickets = Ticket::selectRaw('source_report, AVG(ABS(TIMESTAMPDIFF(MINUTE, response_time, report_time))) as avg_time')
                    ->whereBetween('response_time', [$firstDayOfMonth, $lastDayOfMonth])
                    ->groupBy('source_report')
                    ->get();
            } else {
                $workOrders = WorkOrder::where('user_cid', $user->cid)->where('status', 'Resolved')->get();
                $tickets = Ticket::selectRaw('source_report, AVG(ABS(TIMESTAMPDIFF(MINUTE, response_time, report_time))) as avg_time')
                    ->whereBetween('response_time', [$firstDayOfMonth, $lastDayOfMonth])
                    ->where('user_cid', $user->cid)
                    ->groupBy('source_report')
                    ->get();
            }
            // return view('dashboard::index');


            $months = Config::get('onexolution.months');
            // $staffTimes = [];

            // foreach ($workOrders as $workOrder) {
            //     $staff = json_encode($workOrder['staff']);
            //     $startTime = Carbon::parse($workOrder['start_time']);
            //     $endTime = Carbon::parse($workOrder['end_time']);
            //     $timeDiff = $endTime->diffInMinutes($startTime);

            //     if (!isset($staffTimes[$staff])) {
            //         $staffTimes[$staff] = [];
            //     }

            //     $staffTimes[$staff][] = $timeDiff;
            // }

            // $avgTimes = [];

            // foreach ($staffTimes as $staff => $times) {
            //     $avgTime = count($times) > 0 ? array_sum($times) / count($times) : 0;
            //     $avgTimes[] = [
            //         'staff' => $staff,
            //         'avg_time' => $avgTime,
            //     ];
            // }

            // $data = WorkOrder::selectRaw('staff, AVG(TIMESTAMPDIFF(MINUTE, end_time, start_time)) as avg_time')
            //     ->groupBy('staff')
            //     ->get();

            return view('dashboard::custom.index', compact(['tickets', 'months', 'company']));
        } else {
        }
    }

    public function index()
    {
        $user = auth()->user();
        $company = Company::where('cid', $user->cid)->first();

        if ($user) {
            $firstDayOfMonth = Carbon::now()->startOfMonth();
            $lastDayOfMonth = Carbon::now()->endOfMonth();

            // Split Env local data
            if (isLocal()) {
                // Code for local environment
                $workOrders = WorkOrder::where('status', 'Resolved')->get();
                $tickets = Ticket::selectRaw('source_report, AVG(ABS(TIMESTAMPDIFF(MINUTE, response_time, report_time))) as avg_time')
                    ->whereBetween('response_time', [$firstDayOfMonth, $lastDayOfMonth])
                    ->groupBy('source_report')
                    ->get();
            } else {
                $workOrders = WorkOrder::where('user_cid', $user->cid)->where('status', 'Resolved')->get();
                $tickets = Ticket::selectRaw('source_report, AVG(ABS(TIMESTAMPDIFF(MINUTE, response_time, report_time))) as avg_time')
                    ->whereBetween('response_time', [$firstDayOfMonth, $lastDayOfMonth])
                    ->where('user_cid', $user->cid)
                    ->groupBy('source_report')
                    ->get();
            }
            // return view('dashboard::index');


            $months = Config::get('onexolution.months');
            // $staffTimes = [];

            // foreach ($workOrders as $workOrder) {
            //     $staff = json_encode($workOrder['staff']);
            //     $startTime = Carbon::parse($workOrder['start_time']);
            //     $endTime = Carbon::parse($workOrder['end_time']);
            //     $timeDiff = $endTime->diffInMinutes($startTime);

            //     if (!isset($staffTimes[$staff])) {
            //         $staffTimes[$staff] = [];
            //     }

            //     $staffTimes[$staff][] = $timeDiff;
            // }

            // $avgTimes = [];

            // foreach ($staffTimes as $staff => $times) {
            //     $avgTime = count($times) > 0 ? array_sum($times) / count($times) : 0;
            //     $avgTimes[] = [
            //         'staff' => $staff,
            //         'avg_time' => $avgTime,
            //     ];
            // }

            // $data = WorkOrder::selectRaw('staff, AVG(TIMESTAMPDIFF(MINUTE, end_time, start_time)) as avg_time')
            //     ->groupBy('staff')
            //     ->get();

            return view('dashboard::index', compact(['tickets', 'months', 'company']));
        } else {
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

        $data = Ticket::selectRaw('source_report, AVG(ABS(TIMESTAMPDIFF(MINUTE, response_time, report_time))) as avg_time')
            ->whereBetween('response_time', [$firstDayOfMonth, $lastDayOfMonth])
            ->groupBy('source_report')
            ->get();

        return view('dashboard::charts.average_time_by_source_report', compact(['data', 'months']));
    }

    public function fetchDataAverageTimeBySourceReport(Request $request)
    {
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');
        $user = auth()->user();

        if (isLocal()) {
            $data = DB::table('itsm_reporteds')
                ->select(DB::raw('source, AVG(ABS(TIMESTAMPDIFF(MINUTE, report_time, response_time))) as avg_time'))
                ->whereMonth('report_time', '=', $selectedMonth)
                ->whereYear('report_time', '=', $selectedYear)
                ->groupBy('source')
                ->get();
        } else {
            $data = DB::table('itsm_reporteds')
                ->join('itsm_incidents', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
                ->select(DB::raw('itsm_reporteds.source, AVG(ABS(TIMESTAMPDIFF(MINUTE, itsm_reporteds.report_time, itsm_reporteds.response_time))) as avg_time'))
                ->where('itsm_incidents.kpi', '1')
                ->whereMonth('itsm_reporteds.report_time', '=', $selectedMonth)
                ->whereYear('itsm_reporteds.report_time', '=', $selectedYear)
                ->where('itsm_reporteds.user_cid', $user->cid)
                ->groupBy('itsm_reporteds.source')
                ->get();
        }

        return response()->json($data);
    }

    public function fetchDataAverageTimeHisReport(Request $request)
    {
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');
        $user = auth()->user();

        if (isLocal()) {
            $data = DB::table('itsm_reporteds')
                ->select(DB::raw('category, AVG(ABS(TIMESTAMPDIFF(MINUTE, report_time, response_time))) as avg_time'))
                ->where(function ($query) {
                    $query->where('category', 'LIKE', '%SIMRS%')
                        ->orWhere('category', 'LIKE', '%HIS%');
                })
                ->whereMonth('created_at', '=', $selectedMonth)
                ->whereYear('created_at', '=', $selectedYear)
                ->groupBy('category')
                ->get();
        } else {
            // $data = DB::table('itsm_incidents')
            // ->join('itsm_reporteds', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
            // ->select(DB::raw('itsm_reporteds.category, AVG(ABS(TIMESTAMPDIFF(MINUTE, itsm_reporteds.report_time, itsm_reporteds.resolved_time))) as avg_time'))
            // // ->whereIn('itsm_reporteds.category',['HIS'])
            // ->where(function ($query) {
            //     $query->where('itsm_reporteds.category', 'LIKE', '%SIMRS%')
            //         ->orWhere('itsm_reporteds.category', 'LIKE', '%HIS%');
            // })
            // ->whereMonth('itsm_reporteds.report_time', '=', $selectedMonth)
            // ->whereYear('itsm_reporteds.report_time', '=', $selectedYear)
            // ->where('itsm_incidents.user_cid',$user->cid)
            // ->groupBy('itsm_reporteds.category')
            // ->havingRaw('avg_time < 300')
            // ->get();
            // $data = DB::table('itsm_reporteds')
            // ->select(DB::raw('category, AVG(ABS(TIMESTAMPDIFF(MINUTE, report_time, response_time))) as avg_time'))
            // ->where(function ($query) {
            //     $query->where('category', 'LIKE', '%SIMRS%')
            //         ->orWhere('category', 'LIKE', '%HIS%');
            // })
            // ->whereMonth('created_at', '=', $selectedMonth)
            // ->whereYear('created_at', '=', $selectedYear)
            // ->where('user_cid',$user->cid)
            // ->groupBy('category')
            // ->get();

            $data = DB::table('itsm_incidents')
                ->join('itsm_reporteds', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
                ->select(['itsm_reporteds.category', 'itsm_reporteds.report_time', 'itsm_reporteds.resolved_time'])
                // ->whereIn('itsm_reporteds.category',['HIS'])
                ->where(function ($query) {
                    $query->where('itsm_reporteds.category', 'LIKE', '%SIMRS%')
                        ->orWhere('itsm_reporteds.category', 'LIKE', '%HIS%');
                })
                ->whereMonth('itsm_reporteds.report_time', '=', $selectedMonth)
                ->whereYear('itsm_reporteds.report_time', '=', $selectedYear)
                ->where('itsm_incidents.user_cid', $user->cid)
                // ->groupBy('itsm_reporteds.category')
                ->get();

            // Filter the results where avg_time is less than 300 minutes
            $filteredData = $data->filter(function ($item) {
                return strpos($item->category, 'HIS') !== false;
            })->map(function ($item) {
                // Calculate avg_time from report_time and resolved_time
                $diff = Carbon::parse($item->report_time)->diffInMinutes(Carbon::parse($item->resolved_time));

                // Add avg_time to the item
                $item->duration = $diff;

                return $item;
            });

            // Convert the collection to a plain array
            $filteredArray = $filteredData->values()->all();


            // // Get the count of filtered results
            $countA = $filteredData->where('duration', '<', 300)->count();
            $countB = $filteredData->where('duration', '>', 300)->count();

            $result = [
                'name' => 'HIS',
                'total_under' => $countA,
                'total_upper' => $countB,
            ];

            // $data = $filteredData;

            // return response()->json(['count' => $count]);

        }

        // return response()->json(['count' => $count]);
        // return response()->json($data);
        // return response()->json(['filteredData' => $filteredArray]);
        return response()->json([$result]);
    }

    public function fetchDataAverageTimeByStaff(Request $request)
    {
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');
        $user = auth()->user();

        // dd($selectedMonth .'-'. $selectedYear);

        if (isLocal()) {
            // $data = DB::table('itsm_work_orders')
            // ->select(DB::raw('staff, AVG(ABS(TIMESTAMPDIFF(MINUTE, end_time, start_time))) as avg_time'))
            // ->whereMonth('created_at', '=', $selectedMonth)
            // ->whereYear('created_at', '=', $selectedYear)
            // ->groupBy('staff')
            // ->get();

        } else {
            // $data = DB::table('itsm_work_orders')
            // ->join('itsm_reporteds', 'itsm_work_orders.data_id', '=', 'itsm_reporteds.data_id')
            // // ->select(DB::raw('itsm_work_orders.staff as staff, itsm_reporteds.category as category,  AVG(ABS(TIMESTAMPDIFF(MINUTE, itsm_work_orders.end_time, itsm_work_orders.start_time))) as avg_time'), 'itsm_reporteds.resolved_time')
            // ->select(['itsm_work_orders.staff', 'itsm_reporteds.category', 'itsm_work_orders.end_time', 'itsm_work_orders.start_time', 'itsm_reporteds.resolved_time'])
            // // ->whereIn('itsm_reporteds.category', ['Hardware','Network'])
            // // ->whereMonth('itsm_reporteds.resolved_time', '=', $selectedMonth)
            // // ->whereYear('itsm_reporteds.resolved_time', '=', $selectedYear)
            // ->where('itsm_work_orders.status', 'Resolved')
            // ->where('itsm_work_orders.user_cid', $user->cid)
            // // ->groupBy('staff', 'itsm_reporteds.category') // Include category in GROUP BY
            // ->get();

            $data = DB::table('itsm_work_orders')->join('itsm_reporteds', 'itsm_work_orders.data_id', '=', 'itsm_reporteds.data_id')
                ->where('itsm_work_orders.user_cid', $user->cid)
                ->Where('itsm_work_orders.status', 'Completed')
                ->whereMonth('itsm_work_orders.start_time', '=', $selectedMonth)
                ->whereYear('itsm_work_orders.start_time', '=', $selectedYear)
                // ->where('itsm_work_orders.status', 'Resolved')
                ->where(function ($query) {
                    $query->where('itsm_reporteds.category', 'LIKE', '%Network%')
                        ->orWhere('itsm_reporteds.category', 'LIKE', '%Hardware%');
                })
                ->get(['itsm_work_orders.start_time', 'itsm_work_orders.end_time', 'itsm_work_orders.staff']);


            // return $data->toJson();

            $staffTimes = [];

            foreach ($data as $workOrder) {
                // $category = $workOrder->reported->category; // Access the category from the related 'reported' entity
                // $staff = json_encode($workOrder['staff']);
                $staff = $workOrder->staff;
                $startTime = Carbon::parse($workOrder->start_time);
                $endTime = Carbon::parse($workOrder->end_time);
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
        }

        return response()->json($avgTimes);
    }

    public function chart(Request $request)
    {
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');
        $user = auth()->user();

        if (isLocal()) {
            // $data = DB::table('itsm_work_orders')
            // ->select(DB::raw('staff, AVG(ABS(TIMESTAMPDIFF(MINUTE, end_time, start_time))) as avg_time'))
            // ->whereMonth('created_at', '=', $selectedMonth)
            // ->whereYear('created_at', '=', $selectedYear)
            // ->groupBy('staff')
            // ->get();

        } else {
            // $data = DB::table('itsm_work_orders')
            // ->join('itsm_reporteds', 'itsm_work_orders.data_id', '=', 'itsm_reporteds.data_id')
            // // ->select(DB::raw('itsm_work_orders.staff as staff, itsm_reporteds.category as category,  AVG(ABS(TIMESTAMPDIFF(MINUTE, itsm_work_orders.end_time, itsm_work_orders.start_time))) as avg_time'), 'itsm_reporteds.resolved_time')
            // ->select(['itsm_work_orders.staff', 'itsm_reporteds.category', 'itsm_work_orders.end_time', 'itsm_work_orders.start_time', 'itsm_reporteds.resolved_time'])
            // // ->whereIn('itsm_reporteds.category', ['Hardware','Network'])
            // // ->whereMonth('itsm_reporteds.resolved_time', '=', $selectedMonth)
            // // ->whereYear('itsm_reporteds.resolved_time', '=', $selectedYear)
            // ->where('itsm_work_orders.status', 'Resolved')
            // ->where('itsm_work_orders.user_cid', $user->cid)
            // // ->groupBy('staff', 'itsm_reporteds.category') // Include category in GROUP BY
            // ->get();

            $data = DB::table('itsm_work_orders')->join('itsm_reporteds', 'itsm_work_orders.data_id', '=', 'itsm_reporteds.data_id')
                ->where('itsm_work_orders.user_cid', $user->cid)
                ->whereMonth('itsm_work_orders.start_time', '=', $selectedMonth)
                ->whereYear('itsm_work_orders.start_time', '=', $selectedYear)
                ->where('itsm_work_orders.status', 'Resolved')
                ->where(function ($query) {
                    $query->where('itsm_reporteds.category', 'LIKE', '%Network%')
                        ->orWhere('itsm_reporteds.category', 'LIKE', '%Hardware%');
                })
                ->get(['itsm_work_orders.start_time', 'itsm_work_orders.resolved_time', 'itsm_work_orders.staff']);



            $staffTimes = [];

            foreach ($data as $workOrder) {
                // $category = $workOrder->reported->category; // Access the category from the related 'reported' entity
                // $staff = json_encode($workOrder['staff']);
                $staff = $workOrder->staff;
                $startTime = Carbon::parse($workOrder->start_time);
                $endTime = Carbon::parse($workOrder->resolved_time);
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
        }

        return response()->json($avgTimes);
    }

    // public function getDataIncidentService(Request $request)
    // {
    //     $user = auth()->user();
    //     $incidentData = Incident::where('user_cid', $user->cid)
    //         ->selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
    //         ->groupBy('month')
    //         ->get();

    //     $serviceData = Service::where('user_cid', $user->cid)
    //         ->selectRaw('DATE_FORMAT(created_at, "%M") as month, COUNT(*) as total')
    //         ->groupBy('month')
    //         ->get();

    //     $months = [
    //         'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'
    //     ];

    //     $chartData = [];
    //     foreach ($months as $month) {
    //         $incidentRecord = $incidentData->firstWhere('month', $month);
    //         $incidentTotal = $incidentRecord ? $incidentRecord->total : 0;

    //         $serviceRecord = $serviceData->firstWhere('month', $month);
    //         $serviceTotal = $serviceRecord ? $serviceRecord->total : 0;

    //         $chartData[] = ['month' => $month, 'incident_total' => $incidentTotal, 'service_total' => $serviceTotal];
    //     }

    //     // return response()->json(['data' => $chartData]);
    //     return response()->json(['incidentData' => $incidentData, 'serviceData' => $serviceData]);

    // }

    public function getDataIncidentService(Request $request)
    {
        $user = auth()->user();
        $timeRange = $request->input('filter');

        $data = $this->getData($user, $timeRange);

        // return response()->json(['data' => $data]);
        //     // Format data as needed
        // $formattedData = [
        //     'incidentData' => $incidentData,
        //     'serviceData' => $serviceData,
        // ];

        // Return the formatted data as a JSON response
        return response()->json($data);
    }

    private function getData($user, $timeRange)
    {
        $startDate = Carbon::now();
        $endDate = Carbon::now();
        // Inside your controller method
        $incidentData = [];
        $serviceData = [];

        // Adjust start and end dates based on the selected time range
        switch ($timeRange) {
            case 'week':
                // $startDate->startOfWeek();
                // $endDate->endOfWeek();
                $startDate->startOfMonth();
                $endDate->endOfMonth();
                // Get data grouped by week
                $incidentData = $this->getDataByWeek(Incident::class, $user->cid, $startDate, $endDate);
                $serviceData = $this->getDataByWeek(Service::class, $user->cid, $startDate, $endDate);

                break;
            case 'month':
                // $startDate->startOfMonth();
                // $endDate->endOfMonth();
                $startDate->startOfYear();
                $endDate->endOfYear();
                // $incidentData = Incident::where('user_cid', $user->cid)
                //     ->whereBetween('created_at', [$startDate, $endDate])
                //     ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total')
                //     ->groupBy('month')
                //     ->get();

                $incidentData = Incident::join('itsm_reporteds', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
                    ->where('itsm_incidents.user_cid', $user->cid)
                    ->whereBetween('itsm_reporteds.report_time', [$startDate, $endDate])
                    ->selectRaw('MONTHNAME(itsm_reporteds.report_time) as month, COUNT(*) as total')
                    ->groupBy('month')
                    // ->selectRaw('DAYNAME(itsm_reporteds.report_time) as day, COUNT(*) as total')
                    // ->groupBy('day')
                    ->get();

                $serviceData = Service::where('user_cid', $user->cid)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('MONTHNAME(created_at) as month, COUNT(*) as total')
                    ->groupBy('month')
                    ->get();
                break;
                // case 'month':
                //     $startDate->startOfMonth();
                //     $endDate->endOfMonth();
                //     break;
            case 'year':
                $startDate->startOfYear();
                $endDate->endOfYear();
                break;
                // Add more cases for additional time ranges if needed
            case 'day':
                $startDate->startOfDay();
                $endDate->endOfDay();
                // $incidentData = Incident::where('user_cid', $user->cid)
                //     ->whereBetween('created_at', [$startDate, $endDate])
                //     ->selectRaw('DAYNAME(created_at) as day, COUNT(*) as total')
                //     ->groupBy('day')
                //     ->get();
                // $incidentData = Incident::with('reported')
                //     ->where('user_cid', $user->cid)
                //     ->whereBetween('reported.report_time', [$startDate, $endDate])
                //     ->selectRaw('DAYNAME(reported.report_time) as day, COUNT(*) as total')
                //     ->groupBy('day')
                //     ->get();

                $incidentData = Incident::join('itsm_reporteds', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
                    ->where('itsm_incidents.user_cid', $user->cid)
                    ->whereBetween('itsm_reporteds.report_time', [$startDate, $endDate])
                    ->selectRaw('DAYNAME(itsm_reporteds.report_time) as day, COUNT(*) as total')
                    ->groupBy('day')
                    ->get();

                $serviceData = Service::where('user_cid', $user->cid)
                    ->whereBetween('created_at', [$startDate, $endDate])
                    ->selectRaw('DAYNAME(created_at) as day, COUNT(*) as total')
                    ->groupBy('day')
                    ->get();
                break;
        }



        // dd($startDate->toDateTimeString() . ' - ' . $endDate->toDateTimeString());

        return ['incidentData' => $incidentData, 'serviceData' => $serviceData];
    }

    // private function getData($user, $timeRange)
    // {
    //     $startDate = Carbon::now();
    //     $endDate = Carbon::now();

    //     // Adjust start and end dates based on the selected time range
    //     switch ($timeRange) {
    //         case 'week':
    //             $startDate->startOfWeek();
    //             $endDate->endOfWeek();
    //             break;
    //         case 'month':
    //             $startDate->startOfMonth();
    //             $endDate->endOfMonth();
    //             break;
    //         case 'year':
    //             $startDate->startOfYear();
    //             $endDate->endOfYear();
    //             break;
    //         // Add more cases for additional time ranges if needed
    //     }

    //     dd($startDate->toDateTimeString() . ' - ' . $endDate->toDateTimeString());

    //     $incidentData = Incident::where('user_cid', $user->cid)
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->count();

    //     $serviceData = Service::where('user_cid', $user->cid)
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->count();

    //     return ['incidentData' => $incidentData, 'serviceData' => $serviceData];
    //     // return response()->json(['incidentData' => $incidentData, 'serviceData' => $serviceData]);
    // }

    // private function fetchDataBasedOnFilter(Request $request)
    // {
    //     // Implement logic to fetch data based on the selected filter from $request
    //     // For simplicity, using static data here, replace with your logic

    //     $user = auth()->user();
    //     $filter = $request->input('filter');

    //     // Fetch incident data
    //     $incidentData = Incident::where('user_cid', $user->cid)
    //         ->selectRaw('DAYNAME(created_at) as day, COUNT(*) as total')
    //         ->when($filter == 'week', function ($query) {
    //             // If the filter is 'week', group by week
    //             return $query->groupBy(\DB::raw('CONCAT(YEAR(created_at), "-", WEEK(created_at))'));
    //         })
    //         ->when($filter == 'month', function ($query) {
    //             // If the filter is 'month', group by month
    //             return $query->groupBy(\DB::raw('CONCAT(YEAR(created_at), "-", MONTH(created_at))'));
    //         })
    //         ->when($filter == 'day', function ($query) {
    //             // If the filter is 'day', group by day
    //             return $query->groupBy(\DB::raw('DAYNAME(created_at)'));
    //         })
    //         ->get();

    //     // Fetch service data
    //     $serviceData = Service::where('user_cid', $user->cid)
    //         ->selectRaw('DAYNAME(created_at) as day, COUNT(*) as total')
    //         ->when($filter == 'week', function ($query) {
    //             // If the filter is 'week', group by week
    //             return $query->groupBy(\DB::raw('CONCAT(YEAR(created_at), "-", WEEK(created_at))'));
    //         })
    //         ->when($filter == 'month', function ($query) {
    //             // If the filter is 'month', group by month
    //             return $query->groupBy(\DB::raw('CONCAT(YEAR(created_at), "-", MONTH(created_at))'));
    //         })
    //         ->when($filter == 'day', function ($query) {
    //             // If the filter is 'day', group by day
    //             return $query->groupBy(\DB::raw('DAYNAME(created_at)'));
    //         })
    //         ->get();

    //     // Format data as needed
    //     $formattedData = [
    //         'incidentData' => $incidentData,
    //         'serviceData' => $serviceData,
    //     ];

    //     // Return the formatted data as a JSON response
    //     return response()->json($formattedData);
    // }

    // Helper function to get data grouped by week
    // private function getDataByWeek($model, $userCid, $startDate, $endDate)
    // {
    //     return $model::where('user_cid', $userCid)
    //         ->whereBetween('created_at', [$startDate, $endDate])
    //         ->selectRaw('WEEK(created_at) as week, COUNT(*) as total')
    //         ->groupBy('week')
    //         ->get();
    // }

    private function getDataByWeek($model, $userCid, $startDate, $endDate)
    {
        // Get data for existing weeks
        $existingWeeks = $model::where('user_cid', $userCid)
            ->whereBetween('created_at', [$startDate, $endDate])
            // ->selectRaw('WEEK(created_at) as week, COUNT(*) as total')
            ->selectRaw('WEEK(created_at, 1) as week, COUNT(*) as total')
            ->groupBy('week')
            ->get();

        // Get all week numbers in the date range
        $allWeeks = $this->getAllWeekNumbers($startDate, $endDate);

        // Merge the existing weeks with all weeks, filling in zero for missing weeks
        $mergedData = $this->mergeWeeksData($existingWeeks, $allWeeks);

        return $mergedData;
    }

    private function getAllWeekNumbers($startDate, $endDate)
    {
        $allWeeks = [];

        // Start from the Sunday of the first week
        $currentDate = $startDate->copy()->startOfWeek();

        while ($currentDate->lte($endDate)) {
            $allWeeks[] = $currentDate->weekOfYear;
            $currentDate->addWeek();
        }

        return $allWeeks;
    }

    private function mergeWeeksData($existingWeeks, $allWeeks)
    {
        $mergedData = [];

        // Fill in zero for missing weeks
        foreach ($allWeeks as $week) {
            $existing = $existingWeeks->firstWhere('week', $week);

            if ($existing) {
                $mergedData[] = $existing;
            } else {
                $mergedData[] = ['week' => $week, 'total' => 0];
            }
        }

        return collect($mergedData);
    }

    public function report(Request $request)
    {
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');
        $type = $request->input('type');
        $task = $request->input('task');
        $role = $request->input('role');
        $chart = $request->input('chart');
        $user = auth()->user();

        // dd($selectedMonth .'-'. $selectedYear);

        if (isLocal()) {
            // $data = DB::table('itsm_work_orders')
            // ->select(DB::raw('staff, AVG(ABS(TIMESTAMPDIFF(MINUTE, end_time, start_time))) as avg_time'))
            // ->whereMonth('created_at', '=', $selectedMonth)
            // ->whereYear('created_at', '=', $selectedYear)
            // ->groupBy('staff')
            // ->get();

        } else {

            if ($type == 'chart') {
                if ($task == 'GET_RESPONSE_TIME') {
                    $data = DB::table('itsm_incidents')
                        ->join('itsm_reporteds', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
                        ->select(['itsm_reporteds.category', 'itsm_reporteds.report_time', 'itsm_reporteds.response_time'])
                        // ->whereIn('itsm_reporteds.category',['HIS'])
                        ->whereMonth('itsm_reporteds.report_time', '=', $selectedMonth)
                        ->whereYear('itsm_reporteds.report_time', '=', $selectedYear)
                        ->where('itsm_incidents.user_cid', $user->cid)
                        // ->groupBy('itsm_reporteds.category')
                        ->get();

                    // Filter the results where avg_time is less than 300 minutes
                    $filteredData = $data->map(function ($item) {
                        // Calculate avg_time from report_time and response_time
                        $diff = Carbon::parse($item->report_time)->diffInMinutes(Carbon::parse($item->response_time));

                        // Add avg_time to the item
                        $item->duration = $diff;

                        return $item;
                    });

                    // // Convert the collection to a plain array
                    $filteredArray = $filteredData->values()->all();


                    // // // Get the count of filtered results
                    $countA = $filteredData->where('duration', '<', 30)->count();
                    $countB = $filteredData->where('duration', '>', 30)->count();


                    $result = [
                        'name' => 'Reponse Time',
                        'under' => $countA,
                        'upper' => $countB,
                    ];
                }elseif ($task == 'GET_RESOLVE_TIME_HN') {
                    $data = DB::table('itsm_incidents')
                        ->join('itsm_reporteds', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
                        ->select(['itsm_reporteds.category', 'itsm_reporteds.report_time', 'itsm_reporteds.response_time'])
                        ->where(function ($query) {
                            $query->where('itsm_reporteds.category', 'LIKE', '%Network%')
                                ->orWhere('itsm_reporteds.category', 'LIKE', '%Hardware%');
                        })
                        ->whereMonth('itsm_reporteds.report_time', '=', $selectedMonth)
                        ->whereYear('itsm_reporteds.report_time', '=', $selectedYear)
                        ->where('itsm_incidents.user_cid', $user->cid)
                        // ->groupBy('itsm_reporteds.category')
                        ->get();

                         // Filter the results where avg_time is less than 300 minutes
                        $filteredData = $data->map(function ($item) {
                            // Calculate avg_time from report_time and response_time
                            $diff = Carbon::parse($item->report_time)->diffInMinutes(Carbon::parse($item->response_time));

                            // Add avg_time to the item
                            $item->duration = $diff;

                            return $item;
                        });

                        // Get the count of filtered results
                        $countA = $filteredData->where('duration', '<', 120)->count();
                        $countB = $filteredData->where('duration', '>', 120)->count();

                        $result = [
                            'name' => 'Resolve Time',
                            'under' => $countA,
                            'upper' => $countB,
                        ];
                }elseif ($task == 'GET_CATEGORY_COUNT') {
                    $data = DB::table('itsm_incidents')
                    ->join('itsm_reporteds', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
                    ->select('itsm_incidents.category_name', DB::raw('count(*) as category_count'))
                    ->where('itsm_incidents.user_cid', $user->cid)
                    ->whereMonth('itsm_reporteds.report_time', '=', $selectedMonth)
                    ->whereYear('itsm_reporteds.report_time', '=', $selectedYear)
                    ->groupBy('itsm_incidents.category_name')
                    ->get();

                    // $result = $data;

                    return response()->json($data);

                }

            }
        }

        return response()->json([$result]);
    }

    public function dumpData(Request $request)
    {
        $selectedMonth = $request->input('month');
        $selectedYear = $request->input('year');
        $role = $request->input('role');
        $type = $request->input('type');
        $chart = $request->input('chart');
        $module = $request->input('module');

        $user = auth()->user();

        if($role == "it-support"){
            if($chart == "staff"){
                $data = DB::table('itsm_work_orders')
                ->join('itsm_reporteds', 'itsm_work_orders.data_id', '=', 'itsm_reporteds.data_id')
                ->where('itsm_work_orders.user_cid', $user->cid)
                ->whereMonth('itsm_work_orders.start_time', '=', $selectedMonth)
                ->whereYear('itsm_work_orders.start_time', '=', $selectedYear)
                ->where('itsm_work_orders.status', 'Completed')
                ->where(function ($query) {
                    $query->where('itsm_reporteds.category', 'LIKE', '%Network%')
                        ->orWhere('itsm_reporteds.category', 'LIKE', '%Hardware%');
                })
                ->get(['itsm_work_orders.start_time', 'itsm_work_orders.end_time', 'itsm_work_orders.staff']);
                // ->get();

                // return $data;

                if($type == 'rekap'){
                    return response()->json($data);
                    
                }elseif($type == 'detail'){

                    $staffTimes = [];
        
                    foreach ($data as $workOrder) {
                        // $category = $workOrder->reported->category; // Access the category from the related 'reported' entity
                        // $staff = json_encode($workOrder['staff']);
                        $staff = $workOrder->staff;
                        $startTime = Carbon::parse($workOrder->start_time);
                        $endTime = Carbon::parse($workOrder->end_time);
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

                    return response()->json($avgTimes);
                }
            }elseif($chart == "category"){
                $data = DB::table('itsm_incidents')
                ->join('itsm_reporteds', 'itsm_incidents.reported_id', '=', 'itsm_reporteds.id')
                ->select('itsm_incidents.category_name', DB::raw('count(*) as category_count'))
                ->where('itsm_incidents.user_cid', $user->cid)
                ->whereMonth('itsm_reporteds.report_time', '=', $selectedMonth)
                ->whereYear('itsm_reporteds.report_time', '=', $selectedYear)
                ->groupBy('itsm_incidents.category_name')
                ->get();

                    if($type == 'rekap'){
                        return response()->json($data);
                        
                    }elseif($type == 'detail'){
    
                        $staffTimes = [];
            
                        // foreach ($data as $workOrder) {
                        //     // $category = $workOrder->reported->category; // Access the category from the related 'reported' entity
                        //     // $staff = json_encode($workOrder['staff']);
                        //     $staff = $workOrder->staff;
                        //     $startTime = Carbon::parse($workOrder->start_time);
                        //     $endTime = Carbon::parse($workOrder->end_time);
                        //     $timeDiff = $endTime->diffInMinutes($startTime);
            
                        //     if (!isset($staffTimes[$staff])) {
                        //         $staffTimes[$staff] = [];
                        //     }
            
                        //     $staffTimes[$staff][] = $timeDiff;
                        // }
            
                        $avgTimes = [];
            
                        foreach ($staffTimes as $staff => $times) {
                            $avgTime = count($times) > 0 ? array_sum($times) / count($times) : 0;
                            $avgTimes[] = [
                                'staff' => $staff,
                                'avg_time' => $avgTime,
                            ];
                        }
    
                        return response()->json($avgTimes);
                    }

            }
        }
    }

        

}