<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FolderRequest;
use App\Http\Resources\UserFolderResource;
use App\Models\UserFolder;
use App\Repositories\UserFolderRepository;
use App\Services\FolderService;
use Mockery\Exception;

class UserFolderController extends Controller
{
    private $userFolderRepository;
    private $folderService;

    public function __construct()
    {
        $this->userFolderRepository = new UserFolderRepository;
        $this->folderService = new FolderService(new UserFolder);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        return UserFolderResource::collection(
            $this->userFolderRepository->getDataFoldersWithLogins()
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function store(FolderRequest $request)
    {
        $folder = $this->folderService->store(array_merge(
                $request->all(),
                ['user_id' => auth()->user()->id]
            )
        );

        return response()->json([
            'data' => $folder,
            'message' => 'Created folder'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(int $id)
    {
        $folder = UserFolderResource::collection(
            $this->userFolderRepository->getFolderById($id)
        );

        return response()->json($folder);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(FolderRequest $request, int $id)
    {
        try {
            // получить модель для редактирование
            $folderEdit = $this->userFolderRepository->getFolderUpdate($id);
            // отправка модели на редактирование
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $folderDestroy = $this->userFolderRepository->getFolderDelete($id);

        if ($folderDestroy) {
            return $this->folderService->destroy($folderDestroy);
        }
    }
}
