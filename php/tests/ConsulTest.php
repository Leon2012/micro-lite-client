<?php
include_once dirname(__FILE__)."/../vendor/autoload.php";
use leon2012\microlite\registry\consul\Consul;

final class ConsulTest extends PHPUnit_Framework_TestCase
{
    public function testOne()
    {
        $this->assertEquals(0, count(array()));
    }

    public function testListServices()
    {
        $opts  = ['Address' => '127.0.0.1:8500', 'Scheme' => 'http'];
        $r = new Consul($opts);
        $services = $r->listServices();
        print_r($services);
    }

    public function testGetService()
    {
        $opts  = ['Address' => '127.0.0.1:8500', 'Scheme' => 'http'];
        $r = new Consul($opts);
        $service = $r->getService("go.micro.srv.greeter");
        print_r($service);
    }
}