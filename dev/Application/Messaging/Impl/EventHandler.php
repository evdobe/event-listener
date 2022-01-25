<?php

namespace Application\Messaging\Impl;

use Application\Messaging\Handler;
use Application\Messaging\Message;

class EventHandler implements Handler
{
    public function handle(Message $message): void
    {
        echo "Handling message...".$message->getBody()."\n";
    }

}
