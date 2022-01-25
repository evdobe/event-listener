<?php declare(strict_types=1);

namespace Application\Http;

use Infrastructure\Http\Request;
use Infrastructure\Http\Response;

interface Handler
{
    public function handle(Request $request, Response $response);
}
