<?php

namespace PagarMe\Sdk;

class PagarMeException extends \Exception
{
    /**
     * @param string $message
     */
    public function __construct($message)
    {
        parent::__construct(is_string($message) ? $message : json_encode($message), 0);
    }
}
