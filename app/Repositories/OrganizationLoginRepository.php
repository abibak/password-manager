<?php

namespace App\Repositories;

use App\Models\OrganizationFolder;
use App\Models\OrganizationLogin as Model;

class OrganizationLoginRepository extends BaseRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getLoginById(int $id)
    {
        return $this->startCondition()->where('id', $id)->first();
    }

    public function getUserIdFromFolder(int $idFolder)
    {
        return OrganizationFolder::select('user_id')->where('id', $idFolder)->first();
    }

    public function getLoginWithAccess($id)
    {
        $loginData = null;
        $data = $this->startCondition()
            ->select('access', 'access_organization_folders.user_id as access_user_id', 'organization_folders.user_id')
            ->join('organization_folders', function ($join) use ($id) {
                $join->on('organization_logins.organization_folder_id', '=', 'organization_folders.id')
                    ->join('access_organization_folders', 'access_organization_folders.organization_folder_id', '=', 'organization_folders.id')
                    ->where('organization_logins.id', $id);
            })->get();

        if ((boolean)sizeof($data) === false) {
            $updateLoginData = &$loginData;
            $updateLoginData = $this->startCondition()->where('id', $id)->with('folder')->first();
        } else {
            $loginData = $this->startCondition()->where('id', $id)->first();
        }

        return ['model' => $loginData, 'access' => $data];
    }
}
