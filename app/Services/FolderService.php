<?php


namespace App\Services;


use Mockery\Exception;

class FolderService extends Service
{
    public function __construct($model)
    {
        parent::__construct($model);
    }

    public function store(array $data)
    {
        return $this->startCondition()::create($data);
    }

    public function update($folder, array $data)
    {
        if ($folder === null) {
            throw new Exception('Error updated');
        }

        return $folder->update($data);
    }
}
