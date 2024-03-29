<?php declare(strict_types=1);

namespace Application\Messaging\Impl;

use Application\Event\Store;
use Application\Messaging\Handler;
use Application\Messaging\Message;
use Application\Messaging\Filter;
use Application\Messaging\Translator;

class EventHandler implements Handler
{
    public function __construct(protected Store $store, protected ?Filter $filter = null, protected ?Translator $translator = null)
    {
        echo "Initializing handler with filter ".($filter?$filter::class:'<NONE>')." and translator ".($translator?$translator::class:'<NONE>')."\n";
    }

    public function handle(Message $message, string $channel): void
    {
        if (empty($message->getProperties()['id'])){
            throw new \Exception('Invalid message with empty id property!');
        }
        if ($this->store->hasEvent(sourceId: $message->getProperties()['id'], channel: $channel, timestamp: $message->getProperties()['timestamp'])){
            echo "Skipping duplicate message with id: ".$message->getProperties()['id']." from channel: ".$channel."...\n";
            return;
        }
        if ($this->filter && !$this->filter->matches($message)){
            echo "Skipping unmatched message with id: ".$message->getProperties()['id']." from channel: ".$channel."...\n";
            return;
        }
        if ($this->translator){
            $message = $this->translator->translate($message);
        }
        echo "Handling message with id: ".$message->getProperties()['id']." from channel: ".$channel."...\n";
        $this->store->add(message: $message, channel: $channel);
        echo "Successfully added message to store.\n";
    }

}
