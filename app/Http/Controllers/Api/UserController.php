<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Http\Requests\UserStoreRequest;
use App\Mail\CreatedUser;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    private $userRepository;
    private $accountService;

    public function __construct()
    {
        $this->userRepository = new UserRepository;
        $this->accountService = new AccountService(new User());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->userRepository->getAllUsers();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserStoreRequest $request)
    {
        return $this->accountService->store($request->all());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(AccountRequest $request, $id = null)
    {
        $user = $this->userRepository->getUserEdit();
        return $this->accountService->update($user, $request->all());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(mixed $id)
    {
        return $this->accountService->destroy($id);
    }

    public function changeStatusDeactivateAccount(int $id)
    {
        return $this->accountService->changeStatusDeactivateAccount($id);
    }
}
