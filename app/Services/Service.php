<?php


namespace App\Services;


abstract class Service
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function startCondition()
    {
        return clone $this->model;
    }
}
