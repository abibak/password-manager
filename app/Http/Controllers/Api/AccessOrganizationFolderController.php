<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccessOrganizationFolderRequest;
use App\Models\AccessOrganizationFolder;
use App\Repositories\AccessOrganizationFolderRepository;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

class AccessOrganizationFolderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     */
    public function index(UserRepository $userRepository)
    {
        return response()->json(['data' => $userRepository->getLogins()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(AccessOrganizationFolderRequest $request)
    {
        $createAccess = AccessOrganizationFolder::create([
            'organization_folder_id' => $request->organization_folder_id,
            'user_id' => $request->user_id,
            'access' => $request->access,
        ]);

        if ($createAccess) {
            return response()->json(['message' => 'Created'], 201);
        }
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

    public function changeAccessStatus(Request $request, AccessOrganizationFolderRepository $repository)
    {
        return $repository->changeAccess($request->all());
    }
}
