<?php
/*
 * Project: exception
 * File Created: 2019-05-31 11:27:29
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-31 11:27:41
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\exception;

use leon2012\microlite\Exception;

class ErrorParamExceptoin extends Exception
{
    public function __construct($message, $code = 400)
    {
        $format = "ErrorParam Exception : {%s}";
        $message = sprintf($format, $message);
        parent::__construct($message, $code);
    }
}