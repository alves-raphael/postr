<?php

namespace App\Network;

use GuzzleHttp\Client;

class Sender {

    private $client;
    private $logger;

    public function __construct($params = null){
        parent::__construct($params);
        $this->client = new Client();
        $this->logger = new Log();
    }

}