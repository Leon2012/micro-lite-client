<?php
/*
 * Project: exception
 * File Created: 2019-05-16 11:32:07
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-16 11:32:11
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\exception;

use leon2012\microlite\Exception;

class NotFoundException extends leon2012\microlite\Exception
{
    public function __construct($message, $code = 404)
    {
        $format = "Notfound Exception : {%s}";
        $message = sprintf($format, $message);
        parent::__construct($message, $code);
    }
}