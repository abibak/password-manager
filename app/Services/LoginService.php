<?php


namespace App\Services;


use App\Http\Resources\OrganizationLoginResource;
use App\Http\Resources\UserLoginResource;
use App\Repositories\AccessOrganizationFolderRepository;
use App\Repositories\OrganizationLoginRepository;
use App\Repositories\UserLoginRepository;

class LoginService extends Service
{
    private $userLoginRepository;
    private $orgLoginRepository;
    private $accessOrgFolderRepository;

    public function __construct($model)
    {
        parent::__construct($model);

        $this->userLoginRepository = new UserLoginRepository;
        $this->orgLoginRepository = new OrganizationLoginRepository;
        $this->accessOrgFolderRepository = new AccessOrganizationFolderRepository;
    }

    public function store($request)
    {
        $modelExplode = explode('\\', $this->startCondition()::class);

        if (strtolower($modelExplode[2]) === 'organizationlogin') {
            $getOrgFolderOwnerId = $this->orgLoginRepository->getUserIdFromFolder($request['organization_folder_id']);  // получить id владельца папки
            $orgFolderAccessUser = $this->accessOrgFolderRepository->getAccessByUserId($request['organization_folder_id']);  // получить доступ пользователя к папке

            // проверить, является ли пользователь владельцем папки
            if ($getOrgFolderOwnerId->user_id ?? '' === auth()->user()->id || (int)$orgFolderAccessUser->access === 3) {
                $create = $this->startCondition()::create($request);

                return response()->json([
                    'data' => OrganizationLoginResource::collection([$create]),
                    'message' => 'Created',
                ], 201);
            }

            return response()->json(['message' => 'No execute access'], 403);
        }

        $getFolderOwnerId = $this->userLoginRepository->getUserIdFromFolder($request['user_folder_id']);

        if ($getFolderOwnerId->user_id === auth()->user()->id) {
            $create = $this->startCondition()::create($request);

            return response()->json([
                'data' => UserLoginResource::collection([$create]),
                'message' => 'Created',
            ], 201);
        }
    }

    public function show(int $id)
    {
        //
    }

    public function update($dataModel, array $request)
    {

    }

    public function destroy($dataModel)
    {
        //
    }
}
