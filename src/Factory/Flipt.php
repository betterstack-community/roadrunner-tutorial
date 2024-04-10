<?php

namespace Demo\Project\Factory;

use Flipt\Client\ClientTokenAuthentication;
use Flipt\Client\FliptClient;

class Flipt
{
    public function createClient(string $host, string $token): FliptClient
    {
        return new FliptClient(
            host: $host,
            authentication: new ClientTokenAuthentication($token),
        );
    }
}
