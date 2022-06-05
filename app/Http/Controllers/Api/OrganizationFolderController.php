<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\OrganizationFolderResource;
use App\Models\OrganizationFolder;
use App\Repositories\OrganizationFolderRepository;
use App\Services\FolderService;
use Illuminate\Http\Request;
use Mockery\Exception;

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
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($userId)
    {
        return response()->json([
            'data' => $this->organizationFolderRepository->getDataAccessFolders($userId),
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FolderRequest $request, $id)
    {
        try {
            $folderEdit = $this->organizationFolderRepository->getFolderUpdate($id);
            $result = $this->folderService->update($folderEdit, $request->all());

            if ($result) {
                return response()->json([
                    'data' => $folderEdit,
                    'message' => 'Updated folder'
                ]);
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
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
