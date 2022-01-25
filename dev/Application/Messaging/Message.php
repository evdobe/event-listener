<?php declare(strict_types=1);

namespace Application\Messaging;

interface Message
{

    public function getBody():string;

    public function getHeaders():array;

    public function getHeader(string $name, mixed $default):mixed;

    public function getProperties():array;

    public function getPropery(string $name, mixed $default):mixed;

    public function getKey():?string;
}