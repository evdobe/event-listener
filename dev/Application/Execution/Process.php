<?php

namespace Application\Execution;

interface Process
{
    public function __construct(callable $callback);

}
