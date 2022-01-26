<?php

namespace Application\Messaging\Plugin;

use Application\Messaging\Message;
use Application\Messaging\Translator;

class ExampleTranslator1 implements Translator
{
    public function translate(Message $message): Message
    {
        $body = $message->getBody();
        $body.= "! (translated by ExampleTranslator1)";
        return $message->withBody($body);
    }
}
