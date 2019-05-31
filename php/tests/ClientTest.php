<?php
include_once dirname(__FILE__)."/../vendor/autoload.php";
include_once dirname(__FILE__)."/../vendor/autoload.php";
include_once dirname(__FILE__)."/../examples/php/Go/Micro/Srv/Greeter/Request.php";
include_once dirname(__FILE__)."/../examples/php/Go/Micro/Srv/Greeter/Response.php";
include_once dirname(__FILE__)."/../examples/php/Go/Micro/Srv/Greeter/SayClient.php";
include_once dirname(__FILE__)."/../examples/php/GPBMetadata/Hello.php";

use leon2012\microlite\selector\ss\StaticSelector;
use leon2012\microlite\selector\registry\RegistrySelector;
use leon2012\microlite\selector\Options;
use leon2012\microlite\selector\RandomStrategy;
use leon2012\microlite\selector\EndpointFilter;
use leon2012\microlite\registry\consul\Consul;
use leon2012\microlite\selector\SelectOptions;

final class ClientTest extends PHPUnit_Framework_TestCase
{

    public function testCall()
    {
        $options = new Options;
        $options->registry = new Consul();
        $options->strategy = new RandomStrategy();

        $registrySelector = new RegistrySelector($options);
        $node = $registrySelector->select("go.micro.srv.greeter");
        //print_r($node->hostname());

        if ($node) {
            $hostname = $node->hostname();
            $opts = array(
                'credentials' => Grpc\ChannelCredentials::createInsecure(),
            );
            $request = new Go\Micro\Srv\Greeter\Request();
            $request->setName("leon");
            
            $client = new Go\Micro\Srv\Greeter\SayClient($hostname, $opts);
            list($reply, $status) = $client->Hello($request)->wait();
            $msg = $reply->getMsg();
            echo $msg;
        }

    }
}