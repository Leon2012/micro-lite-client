<?php
/*
 * Project: selector
 * File Created: 2019-05-16 10:51:57
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-30 05:49:09
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\selector;

interface Selector
{
    public function init($options);
    public function options();
    public function select($service, $selectorOptions = null);
    public function mark($service, $node);
    public function reset($service);
    public function close();
    public function string();
}

