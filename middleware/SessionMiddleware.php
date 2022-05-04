<?php
declare(strict_types=1);

namespace Middleware;

use App\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RHI;

class SessionMiddleware extends Middleware
{
    public function __invoke(Request $request, RHI $handler): Response
    {
        $this->getSession()->start();
        $response = $handler->handle($request);
        $this->getSession()->save();

        return $response;
    }
}