<?php
/*
 * Project: consul
 * File Created: 2019-05-16 08:20:35
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-16 08:20:40
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\registry\consul;

use leon2012\microlite\registry\Registry;
use leon2012\microlite\registry\Service;
use leon2012\microlite\registry\Node;
use leon2012\microlite\registry\Endpoint;
use leon2012\microlite\registry\Value;
use \DCarbone\PHPConsulAPI\Config;

final class Consul implements Registry
{
    private $_consul;
    private $_opts;
    private $_config;

    public function __construct($options = array())
    {
        $this->init($options);
    }

    public function init($options)
    {
        $this->_opts = $options;
        if (!isset($this->_opts['Address'])) {
            $this->_opts['Address'] = '127.0.0.1:8500';
        }
        if (!isset($this->_opts['Scheme'])) {
            $this->_opts['Scheme'] = 'http';
        }
        $this->_config = new Config($this->_opts);
        $this->_consul = new \DCarbone\PHPConsulAPI\Consul($this->_config);
    }

    public function options()
    {
        return $this->_opts;
    }

    public function register($service, $opts)
    {
        return;
    }

    public function deregister($service)
    {
        return;
    }

    public function getService($name, $tag = "") 
    {
        list($data, $meta, $err) = $this->_consul->Catalog->Service($name, $tag);
        if ($err) {
            return null;
        }
        $serviceMap = [];
        foreach ($data as $id => $info) {
            $serviceName = $info->ServiceName;
            if ($serviceName != $name) {
                continue;
            }
            $serviceTags = $info->ServiceTags;
            $version = Encoding::decodeVersion($serviceTags);
            $id = $info->ServiceID;
            $address = $info->ServiceAddress;
            if (empty($address)) {
                $address = $info->Address;
            }
            $key = $version;
            if (isset($serviceMap[$key])) {
                $service = $serviceMap[$key];
            }else{
                $service = new Service;
                $service->name = $serviceName;
                $endpoints = Encoding::decodeEndpoints($serviceTags);
                $service->version = $version;
                $service->endpoints = $endpoints;
                $service->nodes = [];
                $serviceMap[$key] = $service;
            }
            $del = false;
            if (isset($info->Checks)) {
                foreach ($info->Checks as $check) {
                    if ($check->Status == "critical") {
                        $del = true;
                        break;
                    }
                }
            }
            if ($del) {
                continue;
            }
            $node = new Node;
            $node->id = $id;
            $node->address = $address;
            $node->port = $info->ServicePort;
            $metadata = Encoding::decodeMetadata($serviceTags);
            $node->metadata = $metadata;
            $service->nodes[] = $node;
        }
        $services = [];
        foreach($serviceMap as $key => $service) {
            $services[] = $service;
        }
        return $services;
    }

    public function listServices()
    {   
        $services = [];
        list($data, $meta, $err) = $this->_consul->Catalog->Services();
        if ($err) {
            return $services;
        }
        foreach ($data as $name => $detail) {
            $services[] = $name;
        }
        return $services;
    }

    public function watch($opts)
    {
        return;
    }

    public function string()
    {
        return "consul";
    }

}