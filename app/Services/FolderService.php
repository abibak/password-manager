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
        try {
            $folder = $this->startCondition()::create($request);

            if (!$folder) {
                throw new \Exception('Error create folder');
            }

            return response()->json([
                'data' => $folder,
                'message' => 'Created folder'
            ], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
    }

    public function show(int $id)
    {
        //
    }

    public function update($dataModel, array $data)
    {
        try {
            if ($dataModel === null || !$dataModel->update($data)) {
                throw new Exception('Error updated');
            }

            return response()->json([
                'message' => 'Updated folder'
            ]);

        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()]);
        }
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
