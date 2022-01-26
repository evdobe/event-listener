<?php

namespace Application\Messaging;

interface Filter
{
    public function matches(Message $message):bool;

}
