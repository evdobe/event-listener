<?php declare(strict_types=1);

namespace Application\Messaging;

interface Handler
{
    public function handle(Message $message): void;
}
