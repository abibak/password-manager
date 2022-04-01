<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserLoginRequest;
use App\Http\Resources\UserFolderResource;
use App\Http\Resources\UserLoginResource;
use App\Models\UserLogin;
use App\Repositories\UserLoginRepository;
use Illuminate\Http\Request;
use function GuzzleHttp\Promise\all;

class UserLoginDataController extends Controller
{
    private $userLoginRepository;

    public function __construct()
    {
        $this->userLoginRepository = new UserLoginRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        /*$logins = UserLoginResource::collection($this->userLoginRepository->getDataLoginsByUserId());
        return response()->json(['data' => $logins]);*/
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param UserLoginRequest $loginRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $folder = $this->userLoginRepository->getUserIdFromFolder($request->user_folder_id);

        /* проверка прав на создание записи */
        if ($folder[0]->user_id === auth()->user()->id) {
            $create = UserLogin::create($request->all());

            return response()->json([
                'data' => UserLoginResource::collection([$create]),
                'message' => 'Created',
            ], 201);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        return response()->json([
            'data' => UserLoginResource::collection(
                $this->userLoginRepository->getDataLoginsByFolderId($id)[0]->logins
            )
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
