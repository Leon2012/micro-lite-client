<?php
/*
 * Project: registry
 * File Created: 2019-05-31 03:59:21
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-31 03:59:26
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\registry;

class Node
{
    public $id;
    public $address;
    public $port;
    public $metadata;
}

class Endpoint 
{
    public $name;
    public $request;
    public $response;
    public $metadata;
}

class Value
{
    public $name;
    public $type;
    public $values;
}