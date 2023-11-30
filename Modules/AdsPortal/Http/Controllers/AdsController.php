<?php

namespace Modules\AdsPortal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdsPortal\DataTables\AdsDataTable;
use Modules\AdsPortal\DataTables\AdsImageDataTable;
use Modules\AdsPortal\DataTables\AdsScheduleDataTable;
use Modules\AdsPortal\DataTables\AdsScheduleAdminDataTable;
use Modules\AdsPortal\Entities\AdsSchedule;
use Yajra\DataTables\DataTables;
use Modules\AdsPortal\Entities\AdsSite;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Modules\AdsPortal\Entities\Ads;

class AdsController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if(auth()->user()->can('access ads portal') && auth()->user()->can('read ads portal')) {
                return $next($request);
            }

            abort(403, 'Unauthorized access.');
        });
    }

    // public function index(AdsDataTable $dataTable)
    // {
    //     return $dataTable->render('adsportal::ads.show');
    // }

    // public function index(AdsDataTable $dataTable, AdsSite $sites)
    // {
    //     // $sites = AdsSite::all();
    //     $users = User::all();

    //     // dd($sites);
    //     return $dataTable
    //         ->render('adsportal::ads.show', compact(['sites', 'users']));
    // }

    public function indexImage(AdsImageDataTable $dataTable, User $user, AdsSite $adsSite)
    {
        $users = $user->all();
        $sites = $adsSite->all();

        return $dataTable->render('adsportal::ads.show', [
            'users' => $users,
            'sites' => $sites,
        ]);
    }

    public function indexPending(AdsScheduleAdminDataTable $dataTable, User $user, AdsSite $adsSite)
    {
        $users = $user->all();
        $sites = $adsSite->all();

        return $dataTable->render('adsportal::ads.showPending', [
            'users' => $users,
            'sites' => $sites,
        ]);
    }

    public function index(AdsDataTable $dataTable, User $user, AdsSite $adsSite)
    {
        $users = $user->all();
        $sites = $adsSite->all();

        return $dataTable->render('adsportal::ads.show', [
            'users' => $users,
            'sites' => $sites,
        ]);
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    // public function index()
    // {
    //     return view('adsportal::index');
    // }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('adsportal::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('adsportal::show');
    }

    // public function getAdsScheduleData($adsId)
    // public function getAdsScheduleData(AdsScheduleDataTable $dataTable, Request $request, User $user, AdsSite $adsSite)
    public function getAdsScheduleAdminData(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
                $model = AdsSchedule::with(['user', 'client', 'ads', 'site'])
                                    ->get(); // eager load the user and client relations
                
                
                return Datatables::of($model)
                    ->addIndexColumn()
                    ->editColumn('DT_RowIndex', function ($row) {
                        return $row->index+1;  // Update the row index
                    })
                    ->editColumn('user_id', function ($model) {
                        return $model->user->name; // return the user's name
                    })
                    ->editColumn('client_id', function ($model) {
                        return $model->client->name; // return the client's name
                    })
                    ->editColumn('ads_id', function ($model) {
                        return $model->ads->name; // return the client's name
                    })
                    ->editColumn('site_id', function ($model) {
                        return $model->site->sites; // return the client's name
                    })
                    ->editColumn('status', function ($model) {
                        $status = $model->status; // return the client's name
                        return config('onexolution.statusAdsSchedule')[$status]; // return the client's name
                    })
                    // ->editColumn('status', function($model) {
                    //     return view('adsportal::ads.columns._statusAds', compact('model'));
                    // })
                    ->editColumn('days', function ($model) {
                        $days = $model->days; // return the client's name
                        return config('onexolution.days')[$days]; // return the client's name
                    })
                    ->removeColumn(['created_at','updated_at']) 
                    ->rawColumns(['DT_RowIndex','status']) // allow HTML in the DT_RowIndex column
                    ->make(true);
            }
    }

    public function getAdsScheduleData(Request $request)
    {
        // dd($request->all());
        if ($request->ajax()) {
                $model = AdsSchedule::with(['user', 'client', 'ads', 'site'])
                                    ->where('ads_id',$request->adsId)
                                    ->get(); // eager load the user and client relations
                
                
                return Datatables::of($model)
                    ->addIndexColumn()
                    ->editColumn('DT_RowIndex', function ($row) {
                        return $row->index+1;  // Update the row index
                    })
                    ->editColumn('user_id', function ($model) {
                        return $model->user->name; // return the user's name
                    })
                    ->editColumn('client_id', function ($model) {
                        return $model->client->name; // return the client's name
                    })
                    ->editColumn('ads_id', function ($model) {
                        return $model->ads->name; // return the client's name
                    })
                    ->editColumn('site_id', function ($model) {
                        return $model->site->sites; // return the client's name
                    })
                    ->editColumn('status', function ($model) {
                        $status = $model->status; // return the client's name
                        return config('onexolution.statusAdsSchedule')[$status]; // return the client's name
                    })
                    // ->editColumn('status', function($model) {
                    //     return view('adsportal::ads.columns._statusAds', compact('model'));
                    // })
                    ->editColumn('days', function ($model) {
                        $days = $model->days; // return the client's name
                        return config('onexolution.days')[$days]; // return the client's name
                    })
                    ->removeColumn(['created_at','updated_at']) 
                    ->rawColumns(['DT_RowIndex','status']) // allow HTML in the DT_RowIndex column
                    ->make(true);
            }
    }

    public function getAdsShowtime(Request $request)
    {
        $currentDay = Carbon::now()->dayOfWeekIso;
        // if ($request->ajax()) {
                $model = AdsSchedule::where('days',$currentDay)->get(['days','ads_time','url']); // eager load the user and client relations
                
                // return $currentDay;
                return Datatables::of($model)
                    ->make(true);
            // }
    }

    public function getAdsImage(Request $request)
    {
        $currentDay = Carbon::now()->dayOfWeekIso;
        // if ($request->ajax()) {
                $model = AdsSchedule::where('days',$currentDay)->where('site_id',$request->siteId)->get(['days','ads_time','url']); // eager load the user and client relations

                return $model->toJson();
                
                // return $currentDay;
                // return Datatables::of($model)
                //     ->make(true);
            // }
    }
    // public function getAdsImage(Request $request)
    // {
    //     $currentDay = Carbon::now()->dayOfWeekIso;
    //     // if ($request->ajax()) {
    //             $model = AdsSchedule::where('days',$currentDay)->get(['days','ads_time','url']); // eager load the user and client relations

    //             return $model->toJson();
                
    //             // return $currentDay;
    //             // return Datatables::of($model)
    //             //     ->make(true);
    //         // }
    // }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('adsportal::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
