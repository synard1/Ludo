<?php

namespace Modules\AdsPortal\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\AdsPortal\DataTables\SitesDataTable;

class AdsSiteController extends Controller
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
    
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    // public function index($SitesDataTable $dataTable)
    // {
    //     return view('adsportal::index');
    // }

    public function index(SitesDataTable $dataTable)
    {
        return $dataTable->render('adsportal::sites.show');
    }

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
