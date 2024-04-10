<?php

namespace Demo\Project\Factory;

use Nyholm\Psr7\Factory\Psr17Factory;
use Vault\AuthenticationStrategies\UserPassAuthenticationStrategy;
use Vault\Client;

class Vault
{
    public function __construct(
       private readonly Psr17Factory $factory
    ) {}

    public function createClientFromEnvironment(): Client
    {
        $host = getenv('VAULT_HOST');
        $user = getenv('VAULT_USER');
        $pass = getenv('VAULT_PASS');

        $factory = $this->factory;
        $client = new Client(
            $factory->createUri($host),
            new \GuzzleHttp\Client(),
            $factory,
            $factory,
        );

        $client->setAuthenticationStrategy(new UserPassAuthenticationStrategy($user, $pass))->authenticate();

        return $client;
    }
}
