<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\OrganizationFolderCollection;
use App\Http\Resources\OrganizationFolderResource;
use App\Models\OrganizationFolder;
use App\Models\UserFolder;
use App\Repositories\OrganizationFolderRepository;
use App\Services\FolderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrganizationFolderController extends Controller
{
    private $organizationFolderRepository;
    private $folderService;

    public function __construct()
    {
        $this->organizationFolderRepository = new OrganizationFolderRepository;
        $this->folderService = new FolderService(new OrganizationFolder);
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
    public function store(FolderRequest $request)
    {
        $folder = $this->folderService->store(array_merge(
                $request->all(),
                ['user_id' => auth()->user()->id]
            )
        );

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
        $folderDestroy = $this->organizationFolderRepository->getFolderDelete($id);
        $this->folderService->destroy($folderDestroy);
    }
}
