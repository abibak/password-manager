<?php

namespace App\Services;


use App\Models\Role;
use App\Repositories\RoleRepository;

class RoleService extends Service
{
    private $roleRepository;

    public function __construct($model)
    {
        parent::__construct($model);
        $this->roleRepository = new RoleRepository();
    }

    public function store(array $request)
    {
        try {
            $role = Role::create($request);

            if ($role) {
                return response()->json([
                    'data' => $role,
                    'message' => 'Role created'
                ], 201);
            }

            throw new \Exception('Error create');
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 422);
        }
    }

    public function show(int $id)
    {
        // TODO: Implement show() method.
    }

    public function update($dataModel, array $request)
    {
        // TODO: Implement update() method.
    }

    public function destroy($dataModel)
    {
        if ($this->startCondition()->destroy($dataModel)) {
            return response()->json(['message' => 'Role deleted']);
        }

        return response()->json(['message' => 'Error deleted']);
    }

    public function changeRoleStatus(int $id)
    {
        try {
            $role = $this->roleRepository->getRoleById($id);
            $status = $role->status;

            if ($status === true) {
                $status = false;
            } else {
                $status = true;
            }

            $this->roleRepository->getRoleById($id)->update([
                'status' => $status,
            ]);

            return response()->json(['message' => 'Status updated'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }
}
