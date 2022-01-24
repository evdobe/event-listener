<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Infrastructure\Http\Server;
use Infrastructure\Http\Request;
use Infrastructure\Http\Response;

$builder = new DI\ContainerBuilder();
$builder->addDefinitions('config.php');
$container = $builder->build();

$server = $container->get(Server::class);

$server->on(
    "start",
    function (Server $server) {
        echo "HTTP server is started.\n";
    }
);

$server->on(
    "request",
    function (Request $request, Response $response) {
        echo "Handling request.\n";
        $response->end("Hello, World!\n");
    }
);

$server->start();
