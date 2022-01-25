<?php declare(strict_types=1);

require_once __DIR__ . '/vendor/autoload.php';

use Application\Http\Server as HttpServer;
use Application\Http\Request as HttpRequest;
use Application\Http\Response as HttpResponse;
use Application\Http\Handler as HttpHandler;

use Application\Messaging\Consumer as MessagingConsumer;

use Application\Execution\Process;

$builder = new DI\ContainerBuilder();
$builder->addDefinitions('config/di.php');
$container = $builder->build();

$httpServer = $container->get(HttpServer::class);
$httpHandler = $container->get(HttpHandler::class);



$process = $container->make(Process::class, ["callback" => function($process) use ($container){
    echo "Starting process...\n";
    $messagingConsumer = $container->get(MessagingConsumer::class);
    $messagingConsumer->start();
}]);

$httpServer->addProcess($process);

$httpServer->on(
    "start",
    function (HttpServer $httpServer) {
        echo "HTTP httpServer is started.\n";
    }
);

$httpServer->on(
    "request",
    function (HttpRequest $request, HttpResponse $response) use ($httpHandler){
        $httpHandler->handle($request, $response);
    }
);

$httpServer->start();
