<?php


namespace App\Services;


abstract class Service
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    /* clone model */
    public function startCondition()
    {
        return clone $this->model;
    }

    abstract public function store(array $request);

    abstract public function show(int $id);

    abstract public function update($dataModel, array $request);

    abstract public function destroy($dataModel);
}
