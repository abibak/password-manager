<?php


namespace App\Repositories;


use App\Models\AccessOrganizationFolder as Model;


class AccessOrganizationFolderRepository extends BaseRepository
{
    public function getModelClass()
    {
        return Model::class;
    }

    public function getAccessByUserId(int $idFolder)
    {
        return $this->startCondition()
            ->select('access')
            ->where('organization_folder_id', $idFolder)
            ->first();
    }

    public function changeAccess($request)
    {
        try {
            $update = $this->startCondition()
                ->where('organization_folder_id', $request['folder_id'])
                ->where('user_id', $request['user_id'])
                ->update([
                    'access' => $request['access'],
                ]);

            if (!$update) {
                throw new \Exception('Model not found');
            }

            return response()->json(['message' => 'Access updated']);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
