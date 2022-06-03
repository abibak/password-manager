<?php

namespace App\Exceptions;

use Exception;

class UserNotFoundException extends Exception
{
    public function report()
    {
        //
    }

    public function render()
    {
        return response()->json(['message' => ['error' => [$this->getMessage()]]], 401);
    }
}
