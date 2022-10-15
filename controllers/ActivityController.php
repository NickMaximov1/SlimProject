<?php
declare(strict_types=1);

namespace Controller;

use App\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Repository\ActionRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ActivityController extends Controller
{
    /**
     * View all activity in site
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function viewActivity(Request $request, Response $response): Response
    {
        $actionRepo = new ActionRepository();
        $actions = $actionRepo->getAllActions($this->getDatabase());
        $body = $this->getTwig()->render('activity.twig', [
            'actions' => $actions,
            'user' => $this->getSession()->getData('user')
        ]);
        $response->getBody()->write($body);

        return $response;
    }
}