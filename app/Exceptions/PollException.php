<?php

namespace App\Exceptions;

use Exception;

class PollException extends Exception
{
    public function __construct($message)
    {
        parent::__construct($message);
    }
}
