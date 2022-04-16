<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserLoginResource;
use App\Models\UserLogin;
use App\Repositories\OrganizationLoginRepository;
use App\Repositories\UserLoginRepository;
use Illuminate\Http\Request;

class OrganizationLoginController extends Controller
{
    private $organizationLoginRepository;

    public function __construct()
    {
        $this->organizationLoginRepository = new OrganizationLoginRepository;
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
    public function store(Request $request)
    {
        $folder = $this->organizationLoginRepository->getUserIdFromFolder($request->user_folder_id);

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
}
