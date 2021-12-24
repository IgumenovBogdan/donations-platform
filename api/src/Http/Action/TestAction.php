<?php

declare(strict_types=1);

namespace App\Http\Action;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class TestAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write("<h1>This is a test page</h1>");

        return $response
            ->withHeader('Content-Type', 'text/html')
            ->withStatus(200);
    }
}