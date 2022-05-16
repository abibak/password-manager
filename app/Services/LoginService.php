<?php


namespace App\Services;


use App\Http\Resources\OrganizationLoginResource;
use App\Http\Resources\UserLoginCollection;
use App\Http\Resources\UserLoginResource;
use App\Models\FavoritePassword;
use App\Models\PasswordHistory;
use App\Repositories\AccessOrganizationFolderRepository;
use App\Repositories\OrganizationLoginRepository;
use App\Repositories\UserLoginRepository;
use Mockery\Exception;

class LoginService extends Service
{
    private $userLoginRepository;
    private $orgLoginRepository;
    private $accessOrgFolderRepository;
    private $modelName;

    public function __construct($model = null)
    {
        parent::__construct($model);

        $this->userLoginRepository = new UserLoginRepository;
        $this->orgLoginRepository = new OrganizationLoginRepository;
        $this->accessOrgFolderRepository = new AccessOrganizationFolderRepository;
        $this->modelName = explode('\\', $this->startCondition()::class)[2];
    }

    public function defineTypeLogin(): bool
    {
        if (strtolower($this->modelName) === 'organizationlogin') {
            return true;
        }

        return false;
    }

    public function store($request)
    {
        if ($this->defineTypeLogin()) {
            // получить id владельца папки
            $getOrgFolderOwnerId = $this->orgLoginRepository->getUserIdFromFolder($request['organization_folder_id']);
            // получить доступ пользователя к папке
            $orgFolderAccessUser = $this->accessOrgFolderRepository->getAccessByUserId($request['organization_folder_id']);

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
        $checkUpdate = false;

        try {
            if ($this->defineTypeLogin()) {
                if ($dataModel['model'] === null) {
                    throw new Exception('Model not found');
                }

                // если access пустой, то, выполнить вариант с проверкой владельца папки
                if ((boolean)sizeof($dataModel['access']) === false) {
                    $currentFolder = $dataModel['model']->folder;

                    if ($currentFolder->user_id === auth()->user()->id) {
                        if ($dataModel['model']->update($request)) {
                            return $checkUpdate = true;
                        }
                    }

                    throw new Exception('Error update');
                } else {
                    // пользователи имеющие доступ к папке
                    $accessUser = $dataModel['access'];

                    // найти пользователя из списка имеющих доступ и проверить права на выполнение операции
                    foreach ($accessUser as $item) {
                        if ($item->access_user_id === auth()->user()->id && (int)$item->access === 2 || $item->user_id === auth()->user()->id) {
                            if ($dataModel['model']->update($request)) {
                                return $checkUpdate = true;
                            }
                        }
                        throw new Exception('Error update');
                    }
                }
            }

            if ($dataModel === null) {
                throw new Exception('Model not found');
            }

            // если пользователь владелец папки, то выполнить обновление
            if ($dataModel->folder->user_id === auth()->user()->id) {
                if ($dataModel->update($request)) {
                    unset($dataModel['folder']);

                    return response()->json([
                        'data' => $dataModel,
                        'message' => 'Updated',
                    ], 200);
                }
            }

            throw new Exception('Error update');
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } finally {
            if ($checkUpdate) {
                return response()->json([
                    'message' => 'Updated'
                ], 200);
            }
        }
    }

    public function destroy($dataModel)
    {
        // флаг об успешном удалении
        $checkDelete = false;

        try {
            // обработка модели логина организации
            if ($this->defineTypeLogin()) {
                if ($dataModel['model'] === null) {
                    throw new Exception('Model not found');
                }

                // если access пустой, то, выполнить вариант с проверкой владельца папки
                if ((boolean)sizeof($dataModel['access']) === false) {
                    $currentFolder = $dataModel['model']->folder;

                    if ($currentFolder->user_id === auth()->user()->id) {
                        if ($dataModel['model']->delete()) {
                            return $checkDelete = true;
                        }
                    }

                    throw new Exception('Error delete');
                } else {
                    // пользователи имеющие доступ к папке
                    $accessUser = $dataModel['access'];

                    // найти пользователя из списка имеющих доступ и проверить права на выполнение операции
                    foreach ($accessUser as $item) {
                        if ($item->access_user_id === auth()->user()->id && (int)$item->access === 3 || $item->user_id === auth()->user()->id) {
                            if ($dataModel['model']->delete()) {
                                return $checkDelete = true;
                            }
                        }
                        throw new Exception('Error delete');
                    }
                }
            } else {
                if ($dataModel === null) {
                    throw new Exception('Error delete');
                }

                // если пользователь владелец папки
                if ($dataModel->folder->user_id === auth()->user()->id) {
                    if ($dataModel->delete()) {
                        return $checkDelete = true;
                    }
                }

                throw new Exception('Error delete');
            }
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 400);
        } finally {
            if ($checkDelete) {
                return response()->json([
                    'message' => 'Deleted'
                ], 200);
            }
        }
    }

    public function writeAction($action)
    {
        try {
            if ($this->defineTypeLogin()) {
                $login = $this->startCondition()::where('id', $action['login_id'])->first();

                if ($login !== null) {
                    PasswordHistory::create([
                        'login_id' => $action['login_id'],
                        'user_id' => auth()->user()->id,
                        'action_text' => $action['action'],
                    ]);
                }

                throw new \Exception('Model not found', 422);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function changeStatusFavorite(int $loginId)
    {
        try {
            if ($this->defineTypeLogin()) {
                $typeLogin = 'organization_login_id';
            } else {
                $typeLogin = 'user_login_id';
            }

            $loginFavorite = FavoritePassword::where($typeLogin, $loginId)->first();

            if ($loginFavorite !== null) {
                throw new \Exception('Model already exists');
            }

            FavoritePassword::create([
                $typeLogin => $loginId,
                'user_id' => auth()->user()->id,
            ]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function getFavoritesPassword()
    {
        $user_logins = UserLoginResource::collection($this->userLoginRepository->getFavoritesPassword())->all();
        $org_logins = OrganizationLoginResource::collection($this->orgLoginRepository->getFavoritesPassword())->all();

        return array_merge($user_logins, $org_logins);
    }
}
