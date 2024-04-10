<?php

require __DIR__ . '/../vendor/autoload.php';

// initialize factories
$psr17Factory = new \Nyholm\Psr7\Factory\Psr17Factory();
$vaultFactory = new \Demo\Project\Factory\Vault($psr17Factory);
$fliptFactory = new \Demo\Project\Factory\Flipt();

// initialize the Application kernel
$app = new \Demo\Project\Application($vaultFactory->createClientFromEnvironment(), $fliptFactory);

// create Request object
$worker = \Spiral\RoadRunner\Worker::create();
$creator = new \Spiral\RoadRunner\Http\PSR7Worker($worker, $psr17Factory, $psr17Factory, $psr17Factory);

while ($request = $creator->waitRequest()) {
    // pass Request object to the Application kernel
    $response = $app->handle($request);

    // emit Response
    $creator->respond($response);
}
