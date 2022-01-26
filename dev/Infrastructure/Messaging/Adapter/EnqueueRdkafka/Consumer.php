<?php

namespace Infrastructure\Messaging\Adapter\EnqueueRdkafka;

use Application\Messaging\Consumer as ApplicationConsumer;
use Application\Messaging\Handler;

use Enqueue\RdKafka\RdKafkaContext;
use Enqueue\RdKafka\RdKafkaConnectionFactory;
use Enqueue\RdKafka\RdKafkaTopic;
use Enqueue\RdKafka\RdKafkaConsumer;

class Consumer implements ApplicationConsumer
{

    protected RdKafkaContext $context;

    protected RdKafkaTopic $topic;

    protected RdKafkaConsumer $delegate;

    public function __construct(protected array $config, protected string $channel, protected Handler $handler)
    {
        $this->context = (new RdKafkaConnectionFactory($config))
            ->createContext();
        $this->topic = $this->context->createTopic($channel);
        $this->delegate = $this->context->createConsumer($this->topic);
    }

    public function start(): void
    {
        while(true){
            echo "Listening on channel ".$this->delegate->getQueue()->getTopicName()."...\n";
            try {
                $message = $this->delegate->receive();
                if ($message){
                    $this->handler->handle(new Message($message));
                    $this->delegate->acknowledge($message);
                }
            }
            catch (\LogicException $e){
                echo "RECEIVE ERROR!!! Channel: ".$this->delegate->getQueue()->getTopicName()." Message: ".$e->getMessage()."\n";
                sleep(1);
            }
        }
        
    }
}
