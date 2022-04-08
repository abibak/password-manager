<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\OrganizationFolderRequest;
use App\Http\Resources\OrganizationFolderCollection;
use App\Http\Resources\OrganizationFolderResource;
use App\Models\OrganizationFolder;
use App\Models\UserFolder;
use App\Repositories\OrganizationFolderRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationFolderController extends Controller
{
    protected $organizationFolderRepository;

    public function __construct()
    {
        $this->organizationFolderRepository = new OrganizationFolderRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return OrganizationFolderResource::collection(
            $this->organizationFolderRepository->getDataFoldersWithLogins()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(OrganizationFolderRequest $request)
    {
        $folder = OrganizationFolder::create([
            'user_id' => auth()->user()->id,
            'name' => $request->name,
            'status' => true,
        ]);

        if ($folder) {
            return response()->json([
                'data' => $folder,
                'message' => 'Created folder'
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
