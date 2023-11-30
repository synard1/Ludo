<?php

namespace App\Http\Controllers;

use App\DataTables\UserInfoDataTable;
use App\Http\Requests\CreateUserInfoRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Http\Controllers\AppBaseController;
use App\Repositories\UserInfoRepository;
use Illuminate\Http\Request;
use Flash;

class UserInfoController extends AppBaseController
{
    /** @var UserInfoRepository $userInfoRepository*/
    private $userInfoRepository;

    public function __construct(UserInfoRepository $userInfoRepo)
    {
        $this->userInfoRepository = $userInfoRepo;
    }

    /**
     * Display a listing of the UserInfo.
     */
    public function index(UserInfoDataTable $userInfoDataTable)
    {
    return $userInfoDataTable->render('user_infos.index');
    }



    /**
     * Show the form for creating a new UserInfo.
     */
    public function create()
    {
        return view('user_infos.create');
    }

    /**
     * Store a newly created UserInfo in storage.
     */
    public function store(CreateUserInfoRequest $request)
    {
        $input = $request->all();

        $userInfo = $this->userInfoRepository->create($input);

        Flash::success('User Info saved successfully.');

        return redirect(route('userInfos.index'));
    }

    /**
     * Display the specified UserInfo.
     */
    public function show($id)
    {
        $userInfo = $this->userInfoRepository->find($id);

        if (empty($userInfo)) {
            Flash::error('User Info not found');

            return redirect(route('userInfos.index'));
        }

        return view('user_infos.show')->with('userInfo', $userInfo);
    }

    /**
     * Show the form for editing the specified UserInfo.
     */
    public function edit($id)
    {
        $userInfo = $this->userInfoRepository->find($id);

        if (empty($userInfo)) {
            Flash::error('User Info not found');

            return redirect(route('userInfos.index'));
        }

        return view('user_infos.edit')->with('userInfo', $userInfo);
    }

    /**
     * Update the specified UserInfo in storage.
     */
    public function update($id, UpdateUserInfoRequest $request)
    {
        $userInfo = $this->userInfoRepository->find($id);

        if (empty($userInfo)) {
            Flash::error('User Info not found');

            return redirect(route('userInfos.index'));
        }

        $userInfo = $this->userInfoRepository->update($request->all(), $id);

        Flash::success('User Info updated successfully.');

        return redirect(route('userInfos.index'));
    }

    /**
     * Remove the specified UserInfo from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $userInfo = $this->userInfoRepository->find($id);

        if (empty($userInfo)) {
            Flash::error('User Info not found');

            return redirect(route('userInfos.index'));
        }

        $this->userInfoRepository->delete($id);

        Flash::success('User Info deleted successfully.');

        return redirect(route('userInfos.index'));
    }

    public function company()
    {
        return view('user_infos.company');
    }
}
