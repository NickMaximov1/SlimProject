<?php
declare(strict_types=1);

namespace Controller;

use App\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class IndexController extends Controller
{
    /**
     * View main page
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function viewIndex(Request $request, Response $response): Response
    {
        $body = $this->getTwig()->render('/index.twig', [
            'user' => $this->getSession()->getData('user')
        ]);
        $response->getBody()->write($body);

        return $response;
    }
}