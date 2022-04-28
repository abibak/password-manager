<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\AccountService;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    private $accountService;
    private $userRepository;

    public function __construct()
    {
        $this->accountService = new AccountService(new User);
        $this->userRepository = new UserRepository();
    }

    public function index(Request $request)
    {
        return $request->all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
