<?php declare(strict_types=1);

return [
    \Infrastructure\Http\Server::class => DI\get(\Infrastructure\Http\Adapter\Swoole\Server::class),
    \Infrastructure\Http\Adapter\Swoole\Server::class =>  DI\autowire()
        ->constructorParameter('port', 9501) 
];