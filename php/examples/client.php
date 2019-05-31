<?php
include_once dirname(__FILE__)."/../vendor/autoload.php";
include_once dirname(__FILE__)."/php/Go/Micro/Srv/Greeter/Request.php";
include_once dirname(__FILE__)."/php/Go/Micro/Srv/Greeter/Response.php";
include_once dirname(__FILE__)."/php/Go/Micro/Srv/Greeter/SayClient.php";
include_once dirname(__FILE__)."/php/GPBMetadata/Hello.php";
$hostname = "localhost:37587";
$opts = array(
	'credentials' => Grpc\ChannelCredentials::createInsecure(),
);

$request = new Go\Micro\Srv\Greeter\Request();
$request->setName("leon");

$client = new Go\Micro\Srv\Greeter\SayClient($hostname, $opts);
list($reply, $status) = $client->Hello($request)->wait();
$msg = $reply->getMsg();
echo $msg;

