<?php
/*
 * Project: registry
 * File Created: 2019-05-16 10:51:23
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-16 11:02:24
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\registry;

interface Registry 
{
    public function init($opts);
    public function options();
    public function register($service, $opts);
    public function deregister($service);
    public function getService($name, $tag = "");
    public function listServices();
    public function watch($opts);
    public function string();
}
