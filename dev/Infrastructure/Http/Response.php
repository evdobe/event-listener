<?php

namespace Infrastructure\Http;

interface Response
{
    public function end(string $content = null): void;


}
