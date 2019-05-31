<?php
/*
 * Project: exception
 * File Created: 2019-05-31 10:35:38
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-31 10:35:48
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\exception;

use leon2012\microlite\Exception;

class NoneAvailableException extends Exception
{
    public function __construct($message, $code = 400)
    {
        $format = "Noneavailable Exception : {%s}";
        $message = sprintf($format, $message);
        parent::__construct($message, $code);
    }
}