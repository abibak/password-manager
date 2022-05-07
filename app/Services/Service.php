<?php


namespace App\Services;


abstract class Service
{
    abstract public function store(array $request);
    abstract public function show(int $id);
    abstract public function update($dataModel, array $request);
    abstract public function destroy($dataModel);
}
