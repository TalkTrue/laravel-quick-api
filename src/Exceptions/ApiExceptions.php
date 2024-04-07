<?php
/**
 * Notes:
 * @package Talktrue\LaravelQuickApi\Exceptions
 * @class ApiExceptions
 * @author:TalkTrue 2024-04-07
 */

namespace Talktrue\LaravelQuickApi\Exceptions;
use Exception;

class ApiExceptions extends Exception
{
    public mixed $data = '';

    #[Pure] public function __construct(array $info, $message = null, $data = false)
    {
        $this->data = $data;
        list($code, $msg) = $info;
        parent::__construct($message ?? $msg, $code);
    }
}
