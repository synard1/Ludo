<?php

namespace Modules\UserInfo\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Http\Controllers\AppBaseController;
use App\DataTables\UserInfoDataTable;
use App\Repositories\UserInfoRepository;

class UserInfoController extends AppBaseController
{
    /** @var UserInfoRepository $userInfoRepository*/
    private $userInfoRepository;

    public function __construct(UserInfoRepository $userInfoRepo)
    {
        $this->userInfoRepository = $userInfoRepo;
    }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    // public function index()
    // {
    //     return view('userinfo::index');
    // }

    public function index(UserInfoDataTable $userInfoDataTable)
    {
        return $userInfoDataTable->render('userinfo::user_infos.index');
        // return $userInfoDataTable->render('userinfo::create');
        // return view('userinfo::index')->with('userInfoDataTable', $userInfoDataTable);
        // return view('userinfo::user_infos.index')->with('userInfoDataTable', $userInfoDataTable);

    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('userinfo::create');
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
        return view('userinfo::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('userinfo::edit');
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
