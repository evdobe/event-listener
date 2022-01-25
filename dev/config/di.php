<?php declare(strict_types=1);

return [
    \Application\Http\Server::class => DI\get(\Infrastructure\Http\Adapter\Swoole\Server::class),
    \Infrastructure\Http\Adapter\Swoole\Server::class =>  DI\autowire()
        ->constructorParameter('port', intval(getenv('HTTP_PORT'))),
    \Application\Http\Handler::class => DI\get(\Application\Http\Impl\PingHandler::class),
    \Application\Messaging\Consumer::class => DI\get(\Infrastructure\Messaging\Adapter\EnqueueRdkafka\Consumer::class),
    \Infrastructure\Messaging\Adapter\EnqueueRdkafka\Consumer::class =>  DI\autowire()
        ->constructor(config:[
            'global' => [
                'metadata.broker.list' => getenv('MESSAGING_HOST').':'.getenv('MESSAGING_PORT'),
                'group.id' => getenv('MESSAGING_CONSUMER_GROUP'),
            ],
            'topic' => [
                'auto.offset.reset' => 'earliest',
                'enable.auto.commit' => 'false'
            ],
        ], channel: getenv('MESSAGING_CHANNEL'), handler: DI\get(\Application\Messaging\Handler::class)),
    \Application\Messaging\Handler::class => DI\get(\Application\Messaging\Impl\EventHandler::class),
    \Application\Execution\Process::class => DI\autowire(\Infrastructure\Execution\Adapter\Swoole\Process::class),
    
];