<?php
declare(strict_types=1);

namespace Controller;

use App\Controller;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Repository\ActionRepository;

class ActivityController extends Controller
{
    public function __invoke(Request $request, Response $response): Response
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