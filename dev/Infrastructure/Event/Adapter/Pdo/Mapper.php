<?php

namespace Infrastructure\Event\Adapter\Pdo;

use Application\Event\Mapper as EventMapper;
use Application\Messaging\Message;

class Mapper implements EventMapper
{
    public function map(Message $message, string $channel): array
    {
        return [
            ':name' => $message->getHeader('name'),
            ':channel' => $channel,
            ':correlation_id' => $message->getProperty('correlation_id')?$message->getProperty('correlation_id'):$message->getProperty('id'),
            ':aggregate_id' => $message->getHeader('aggregate_id'),
            ':aggregate_version' => $message->getHeader('aggregate_version'),
            ':data' => $message->getBody(),
            ':timestamp' => $message->getProperty('timestamp')
        ];
    }

}
