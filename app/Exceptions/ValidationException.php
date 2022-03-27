<?php

namespace App\Exceptions;

class ValidationException extends \Illuminate\Validation\ValidationException
{
    public function report()
    {
        return false;
    }

    public function render()
    {
        return response()->json(['errors' => $this->validator->errors()], 422);
    }
}
