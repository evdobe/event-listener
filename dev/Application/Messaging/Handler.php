<?php declare(strict_types=1);

namespace Application\Messaging;

interface Handler
{
    public function __construct(?Filter $filter = null, ?Translator $translator = null);
    public function handle(Message $message): void;
}
