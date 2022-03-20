<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserFolderResource;
use App\Models\UserFolder;
use App\Repositories\UserFolderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserFolderController extends Controller
{
    private $userFolderRepository;

    public function __construct()
    {
        $this->userFolderRepository = new UserFolderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserFolderResource::collection($this->userFolderRepository->getDataFoldersWithLogins());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validation = Validator::make($request->all(), [
            'name' => 'required'
        ]);

        if (!$validation->fails()) {
            $folder = UserFolder::create([
                'user_id' => auth()->user()->id,
                'name' => $request->name,
            ]);

            if ($folder) {
                return response()->json([
                    'data' => $folder,
                    'message' => 'Created folder'
                ], 201);
            }
        }

        return response()->json($validation->errors(), 400);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $folder = UserFolderResource::collection($this->userFolderRepository->getFolderById($id));
        return response()->json($folder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

    }
}
