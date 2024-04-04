<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {

        if (auth()->user()->hasRole('Super Admin')) {
            addVendors(['amcharts', 'amcharts-maps', 'amcharts-stock']);

            return view('pages.dashboards.index');
        }else if(auth()->user()->hasRole('Administrator')){
            return view('pages.dashboards.indexNewUser');
        }

        return view('pages.dashboards.user');

    }
}
