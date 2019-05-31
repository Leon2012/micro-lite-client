<?php
include_once dirname(__FILE__)."/../vendor/autoload.php";

use leon2012\microlite\selector\ss\StaticSelector;
use leon2012\microlite\selector\registry\RegistrySelector;
use leon2012\microlite\selector\Options;
use leon2012\microlite\selector\RandomStrategy;
use leon2012\microlite\selector\EndpointFilter;
use leon2012\microlite\registry\consul\Consul;
use leon2012\microlite\selector\SelectOptions;

final class SelectorTest extends PHPUnit_Framework_TestCase
{
    public function testStatic()
    {
        $staticSelector = new StaticSelector;
        $node = $staticSelector->select("127.0.0.1:8500");
        print_r($node);
    }

    public function testRegistry()
    {
        $options = new Options;
        $options->registry = new Consul();
        $options->strategy = new RandomStrategy();

        $selectOptions = new SelectOptions;
        $selectOptions->filters[] = new EndpointFilter("Say.Hello");

        $registrySelector = new RegistrySelector($options);
        $node = $registrySelector->select("go.micro.srv.greeter", $selectOptions);
        print_r($node);
    }
}
