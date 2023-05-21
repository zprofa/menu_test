<?php

namespace App\Services\Exception;

use Exception;

class ValidationException extends Exception
{
    public function __construct(array $messages)
    {
        parent::__construct(json_encode($messages), 422);
    }
}
