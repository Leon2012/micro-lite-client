<?php
/*
 * Project: selector
 * File Created: 2019-05-30 05:52:45
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-30 05:53:03
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\selector;
use leon2012\microlite\exception\NoneAvailableException;

interface Strategy
{
    public function select($services);
}

