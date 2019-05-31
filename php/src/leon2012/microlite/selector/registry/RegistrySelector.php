<?php
/*
 * Project: selector
 * File Created: 2019-05-31 11:14:49
 * Author: leo.peng (leon.peng@icloud.com)
 * -----
 * Last Modified: 2019-05-31 11:14:54
 * Modified By: leo.peng (leon.peng@icloud.com>)
 * -----
 * Copyright 2019 - 2019
 */
namespace leon2012\microlite\selector\registry;

use leon2012\microlite\selector\Selector;
use leon2012\microlite\selector\RandomStrategy;
use leon2012\microlite\selector\Options;
use leon2012\microlite\exception\ErrorParamExceptoin;
use leon2012\microlite\exception\NoneAvailableException;

class RegistrySelector implements Selector
{
    private $_options;

    public function __construct($options)
    {
        $this->init($options);
    }
    public function init($options)
    {
        if (!($options instanceof Options)) {
            throw new ErrorParamExceptoin("options error");
        }
        if (empty($options->registry)) {
            throw new ErrorParamExceptoin("options registry is empty");
        }
        if (!($options->registry instanceof \leon2012\microlite\registry\Registry)) {
            throw new ErrorParamExceptoin("registry not implement interface");
        }
        if (empty($options->strategy)) {
            $options->strategy = new RandomStrategy;
        }else{
            if (!($options->strategy instanceof \leon2012\microlite\selector\Strategy)) {
                throw new ErrorParamExceptoin("strategy not implement interface");
            }
        }
        $this->_options = $options;
    }
    public function options()
    {
        return $this->_options;
    }
    public function select($service, $selectorOptions = null)
    {
        $services = $this->_options->registry->getService($service);
        if (empty($services)) {
            throw new NoneAvailableException("services by {$service}");
        }
        if (!is_null($selectorOptions) && ($selectorOptions instanceof \leon2012\microlite\selector\SelectOptions)) {
            $filters = $selectorOptions->filters;
            if (is_array($filters)) {
                foreach($filters as $filter) {
                    if ($filter instanceof \leon2012\microlite\selector\Filters) {
                        $services = $filter->filter($services);
                    }
                }
            }
        }
        if (empty($services)) {
            throw new NoneAvailableException("filted services by {$service}");
        }
        $node = $this->_options->strategy->select($services);
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
        return "registry";
    }
}
