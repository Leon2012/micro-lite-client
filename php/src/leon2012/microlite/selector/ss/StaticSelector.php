<?php
/*
 * Project: static
 * File Created: 2019-05-31 10:58:58
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-31 10:59:23
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\selector\ss;

use leon2012\microlite\selector\Selector;
use leon2012\microlite\registry\Node;

class StaticSelector implements Selector
{
    private $_options;

    public function __construct($options = null)
    {
        $this->init($options);
    }
    public function init($options)
    {
        $this->_options = $options;
    }
    public function options()
    {
        return $this->_options;
    }
    public function select($service, $selectorOptions = null)
    {
        $arr = explode(":", $service);
        $addr = $arr[0];
        if (isset($arr[1])) {
            $port = $arr[1];
        }else{
            $port = "0";
        }
        $node = new Node;
        $node->id = $service;
        $node->address = $addr;
        $node->port = $port;
        return $node;
    }
    public function mark($service, $node)
    {

    }
    public function reset($service)
    {

    }
    public function close()
    {

    }
    public function string()
    {
        return "static";
    }
}