<?php declare(strict_types=1);

namespace Application\Http;

interface Server {

    public function start():void;

    public function on(string $eventName, callable $callback):void;
    
}