<?php

namespace Infrastructure\Messaging\Adapter\EnqueueRdkafka;

use Application\Messaging\Message as ApplicationMessage;

use Enqueue\RdKafka\RdKafkaMessage;

class Message implements ApplicationMessage
{
    public function __construct(protected RdKafkaMessage $delegate)
    {
        
    }

    public function getBody():string {
        return $this->delegate->getBody();
    }

    public function getHeaders():array {
        return $this->delegate->getHeaders();
    }

    public function getHeader(string $name, mixed $default):mixed{
        return $this->delegate->getHeader(name: $name, default: $default);
    }

    public function getProperties():array{
        return $this->delegate->getProperties();
    }

    public function getPropery(string $name, mixed $default):mixed{
        return $this->delegate->getProperty(name: $name, default: $default);
    }

    public function getKey():?string{
        return $this->delegate->getKey();
    }

}
