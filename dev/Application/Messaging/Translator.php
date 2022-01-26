<?php

namespace Application\Messaging;

interface Translator
{
    public function translate(Message $message):Message;
}
