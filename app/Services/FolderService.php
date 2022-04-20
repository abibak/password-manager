<?php


namespace App\Services;


use Mockery\Exception;

class FolderService extends Service
{
    public function __construct($model)
    {
        parent::__construct($model);
    }

    public function store(array $request)
    {
        return $this->startCondition()::create($request);
    }

    public function show(int $id)
    {
        //
    }

    public function update($dataModel, array $data)
    {
        if ($dataModel === null) {
            throw new Exception('Error updated');
        }

        return $dataModel->update($data);
    }

    public function destroy($dataModel)
    {
        $modelDelete = $dataModel->delete();

        if (!$modelDelete) {
            return response()->json(['message' => 'Error delete'], 400);
        }

        return response()->json([
            'message' => 'Deleted'
        ], 200);
    }
}
