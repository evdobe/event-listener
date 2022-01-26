<?php

namespace Application\Messaging\Impl;

use Application\Messaging\Handler;
use Application\Messaging\Message;
use Application\Messaging\Filter;
use Application\Messaging\Translator;

class EventHandler implements Handler
{
    public function __construct(protected ?Filter $filter = null, protected ?Translator $translator = null)
    {
        echo "Initializing handler with filter ".($filter?$filter::class:'<NONE>')." and translator ".($translator?$translator::class:'<NONE>')."\n";
    }

    public function handle(Message $message): void
    {
        if ($this->filter && !$this->filter->matches($message)){
            echo "Skipping unmatched message.\n";
            return;
        }
        if ($this->translator){
            $message = $this->translator->translate($message);
        }
        echo "Handling message with body: "
            .$message->getBody().", headers: "
            .print_r($message->getHeaders(), true).", properties: "
            .print_r($message->getProperties(), true)."\n";
    }

}
