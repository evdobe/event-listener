<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Application\Http\Server;
use Application\Http\Request;
use Application\Http\Response;
use Application\Http\Handler;

$builder = new DI\ContainerBuilder();
$builder->addDefinitions('config/di.php');
$container = $builder->build();

$server = $container->get(Server::class);

$handler = $container->get(Handler::class);

$server->on(
    "start",
    function (Server $server) {
        echo "HTTP server is started.\n";
    }
);

$server->on(
    "request",
    function (Request $request, Response $response) use ($handler){
        $handler->handle($request, $response);
    }
);

$server->start();
