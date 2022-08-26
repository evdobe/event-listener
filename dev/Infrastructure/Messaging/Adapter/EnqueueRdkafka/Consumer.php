<?php declare(strict_types=1);

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

    protected RdKafkaTopic $invalidTopic;

    public function __construct(
        protected array $config, 
        protected string $channel, 
        protected Handler $handler, 
        protected ?string $invalidChannel = null)
    {
        $this->context = (new RdKafkaConnectionFactory($config))
            ->createContext();
        $this->topic = $this->context->createTopic($channel);
        $this->delegate = $this->context->createConsumer($this->topic);
        if ($invalidChannel){
            $this->invalidTopic = $this->context->createTopic($invalidChannel);
        }
    }

    public function start(): void
    {
        while(true){
            echo "Listening on channel ".$this->delegate->getQueue()->getTopicName()."...\n";
            try {
                $message = $this->delegate->receive();
                if ($message){
                    $this->handler->handle(message: new Message($message), channel: $this->channel);
                    $this->delegate->acknowledge($message);
                }
            }
            catch (\Exception $e){
                echo "RECEIVE ERROR!!! Channel: "
                    .$this->delegate->getQueue()->getTopicName()
                    ." Error: ".$e::class.", code: ".$e->getCode().", message: ".$e->getMessage()."\n";
                if ($e::class == \PDOException::class){
                    echo "DB ERROR!!! Will NOT REJECT the message. I will re-throw and try again to consume it.";
                    throw $e;
                }
                if (!empty($message)){
                    echo "REJECTING MESSAGE: ".print_r($message, true)."\n";
                    $this->delegate->reject($message);
                    if (!empty($this->invalidTopic)){
                        echo "Sending message to invalid channel...";
                        $invalidProducer = $this->context->createProducer();
                        $message->setProperty("source", $this->delegate->getQueue()->getTopicName());
                        $message->setProperty("invalidBy", $this->config['global']['group.id']);
                        $message->setProperty("invalidAt", (new \DateTime())->format('Y-m-d H:i:s'));
                        $message->setProperty("exception", [
                            'class' => get_class($e),
                            'code' => $e->getCode(),
                            'message' => $e->getMessage(),
                            'trace' => $e->getTraceAsString()
                        ]);
                        $invalidProducer->send($this->invalidTopic, $message);
                    }
                }
            }
        }
        
    }
}
