<?php
declare(strict_types=1);

namespace Controller;

use App\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class IndexController extends Controller
{
    public function __invoke(Request $request, Response $response): Response
    {
        $body = $this->getTwig()->render('/index.twig', [
            'user' => $this->getSession()->getData('user')
        ]);
        $response->getBody()->write($body);

        return $response;
    }
}