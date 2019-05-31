<?php
// GENERATED CODE -- DO NOT EDIT!

namespace Go\Micro\Srv\Greeter;

/**
 */
class SayClient extends \Grpc\BaseStub {

    /**
     * @param string $hostname hostname
     * @param array $opts channel options
     * @param \Grpc\Channel $channel (optional) re-use channel object
     */
    public function __construct($hostname, $opts, $channel = null) {
        parent::__construct($hostname, $opts, $channel);
    }

    /**
     * @param \Go\Micro\Srv\Greeter\Request $argument input argument
     * @param array $metadata metadata
     * @param array $options call options
     */
    public function Hello(\Go\Micro\Srv\Greeter\Request $argument,
      $metadata = [], $options = []) {
        return $this->_simpleRequest('/go.micro.srv.greeter.Say/Hello',
        $argument,
        ['\Go\Micro\Srv\Greeter\Response', 'decode'],
        $metadata, $options);
    }

}
