<?php

declare(strict_types=1);

namespace App\Http\Action;

use Slim\Psr7\Request;
use Slim\Psr7\Response;

class HomeAction
{
    public function __invoke(Request $request, Response $response): Response
    {
        $response->getBody()->write(json_encode([
            'name' => 'App API',
            'version' => '1.0',
        ]));

        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
    }
}