<?php
/*
 * Project: selector
 * File Created: 2019-05-31 03:46:00
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-31 03:46:07
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\selector;

class Options 
{
    public $registry;
    public $strategy;
}

class SelectOptions 
{
    public $filters = [];
    public $strategy;
}

class EndpointFilter implements Filters
{
    private $_name;
    
    public function __construct($name)
    {
        $this->_name = $name;
    }

    public function filter($services)
    {
        return $this->filterEndpoint($services, $this->_name);
    }

    private function filterEndpoint($services, $name)
    {
        $ss = [];
        foreach($services as $service) {
            for($i=0; $i<count($service->endpoints); $i++) {
                $ep = $service->endpoints[$i];
                if ($ep['name'] == $name) {
                    $ss[] = $service;
                    break;
                } 
            }
        }
        return $ss;
    }
}

class LabelFilter implements Filters
{
    private $_key;
    private $_val;

    public function __construct($key, $val)
    {
        $this->_key = $key;
        $this->_val = $val;
    }

    public function filter($services)
    {
        return $this->filterLabel($services, $this->_key, $this->_val);
    }

    private function filterLabel($services, $key, $val)
    {
        $ss = [];
        foreach($services as $service) {
            $s = $service;
            $nodes = [];
            for($i=0; $i<count($service->nodes); $i++) {
                $node = $service->nodes[$i];
                if ($node->metadata) {
                    if (isset($node->metadata[$key]) && ($node->metadata[$key] == $val)) {
                        $nodes[] = $node;
                    }
                }
            }
            if (!empty($nodes)) {
                $s->nodes = $nodes;
                $ss[] = $s;
            }
        }
        return $ss;
    }
}

class RandomStrategy implements Strategy
{
    public function select($services)
    {
        $nodes = [];
        foreach ($services as $service) {
            if (is_array($service->nodes)) {
                for($i=0; $i<count($service->nodes); $i++) {
                    $nodes[] = $service->nodes[$i];
                }
            }
        }
        if (empty($nodes)) {
            throw new NoneAvailableException("service nodes");
        }
        $randIdx = array_rand($nodes);
        return $nodes[$randIdx];
    }
}

class RoundrobinStrategy implements Strategy
{
    public function select($services)
    {
        $nodes = [];
        foreach ($services as $service) {
            if (is_array($service->nodes)) {
                for($i=0; $i<count($service->nodes); $i++) {
                    $nodes[] = $service->nodes[$i];
                }
            }
        }
        if (empty($nodes)) {
            throw new NoneAvailableException("service nodes");
        }
        $randIdx = mt_rand();
        $cnt = count($nodes);
        $idx = $randIdx%$cnt;
        return $nodes[$idx];
    }
}