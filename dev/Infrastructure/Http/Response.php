<?php

namespace Infrastructure\Http;

interface Response
{
    public function end(string $content = null): void;

    public function header(string $key, string $value): void;


}
