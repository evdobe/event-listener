<?php declare(strict_types=1);

return [
    \Application\Http\Server::class => DI\get(\Infrastructure\Http\Adapter\Swoole\Server::class),
    \Infrastructure\Http\Adapter\Swoole\Server::class =>  DI\autowire()
        ->constructorParameter('port', intval(getenv('HTTP_PORT'))),
    \Application\Http\Handler::class => DI\get(\Application\Http\Impl\PingHandler::class)
];