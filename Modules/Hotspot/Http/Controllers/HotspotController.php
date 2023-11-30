<?php

namespace Modules\Hotspot\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Hotspot\Entities\Hotspot;
use App\Models\User;

class HotspotController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('hotspot::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('hotspot::create');
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
        return view('hotspot::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('hotspot::edit');
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

    public function login(Request $request, $weblink)
    {
        $data = $request->all();
        $hotspot = Hotspot::where('weblink', $weblink)->first();
        $check = checkMacAddress($data['mac']);

        // dd($data);
        $user = User::find($hotspot->user_id);
        $userDetail = $user->userDetail;

        // dd($data);

        // if($check["found"] =="true" ){

        // }else{

        //     return view('hotspot.norandom', compact(['data','userDetail', 'user','hotspot']));

        // }

        if($data["trial"] == "yes"){
            return view('hotspot.index', compact(['data','userDetail', 'user','hotspot']));

        }else{
            return view('hotspot.nologin', compact(['data','userDetail', 'user','hotspot']));
        }



    }
}
