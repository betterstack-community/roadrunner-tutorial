<?php

namespace Demo\Project;

use Demo\Project\Factory\Flipt;
use Flipt\Client\FliptClient;
use Nyholm\Psr7\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Vault\Client;

class Application implements RequestHandlerInterface
{
    private FliptClient $flipt;

    public function __construct(Client $vault, Flipt $fliptFactory) {
        $response = $vault->read('/secret/data/demoapp');
        $secret = $response->getData()['data'];
        $this->flipt = $fliptFactory->createClient(
            $secret['flipt_api_host'],
            $secret['flipt_api_token']
        );
    }

    #[\Override] public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $greeting =  "Hello, world!";
        $flag = $this->flipt->boolean('show_reverse_greeting');

        if ($flag->getEnabled()) {
            $greeting = strrev($greeting);
        }

        return new Response(body: $greeting);
    }
}
