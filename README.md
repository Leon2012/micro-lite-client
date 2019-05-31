# micro-lite-client
micro lite client library

### 调用方法

```
vi tests/ClientTest.php

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
```
