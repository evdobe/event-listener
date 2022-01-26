<?php declare(strict_types=1);

namespace Application\Messaging;

use Application\Messaging\Handler;

interface Consumer
{
    public function __construct(array $config, string $channel, Handler $handler, ?string $invalidChannel = null);

    public function start():void;
}
