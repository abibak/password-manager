<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationLoginRequest;
use App\Models\OrganizationLogin;
use App\Repositories\OrganizationLoginRepository;
use App\Services\LoginService;
use Illuminate\Http\Request;

class OrganizationLoginController extends Controller
{
    private $organizationLoginRepository;
    private $loginService;

    public function __construct()
    {
        $this->organizationLoginRepository = new OrganizationLoginRepository;
        $this->loginService = new LoginService(new OrganizationLogin);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrganizationLoginRequest $request)
    {
        return $this->loginService->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return bool|\Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $loginUpdate = $this->organizationLoginRepository->getLoginWithAccess($id);
        return $this->loginService->update($loginUpdate, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $loginDestroy = $this->organizationLoginRepository->getLoginWithAccess($id);
        return $this->loginService->destroy($loginDestroy);
    }

    public function action(Request $request)
    {
        return $this->loginService->writeAction($request->all());
    }

    public function changeStatusFavorite(int $loginId)
    {
        return $this->loginService->changeStatusFavorite($loginId);
    }
}
