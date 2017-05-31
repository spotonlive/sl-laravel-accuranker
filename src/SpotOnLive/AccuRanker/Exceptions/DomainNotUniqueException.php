<?php

namespace SpotOnLive\AccuRanker\Exceptions;

use Throwable;

class DomainNotUniqueException extends \Exception
{
    public function __construct($message = "", $code = 422, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
