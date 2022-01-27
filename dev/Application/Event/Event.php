<?php declare(strict_types=1);

namespace Application\Event;

use DateTimeImmutable;
use DateTimeInterface;

interface Event
{
    public function __construct(
        int|string $id, 
        string $name, 
        string $channel,
        int|string $correlationId,
        int|string $aggregateId,
        int $aggergateVersion,
        object $data,
        DateTimeInterface $occuredAt,
        bool $dispatched,
        DateTimeInterface $dispatchedAt,
        DateTimeInterface $receivedAt,
        bool $projected
    );

}
