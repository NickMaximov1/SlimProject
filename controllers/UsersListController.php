<?php
declare(strict_types=1);

namespace Controller;

use App\Controller;
use CustomExp\BlockException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Repository\UserRepository;

class UsersListController extends Controller
{
    public function viewUsersList(Request $request, Response $response): Response
    {
        $userRepo = new UserRepository();
        $users = $userRepo->getAllUsers($this->getDatabase());
        $body = $this->getTwig()->render('usersList.twig', [
            'users' => $users,
            'user' => $this->getSession()->getData('user')
        ]);
        $response->getBody()->write($body);

        return $response;
    }

    public function blockUnblockUser(Request $request, Response $response): Response
    {
        $userRepo = new UserRepository();
        $params = (array)$request->getParsedBody();
        try {
            $userRepo->blockUnblockUser($params, $this->getDatabase());
        } catch (BlockException $exception) {
            $this->getSession()->setData('message', $exception->getMessage());
            $this->getSession()->setData('form', $params);

            return $response->withHeader('Location', '/users-list')
                ->withStatus(302);
        }

        return $response->withHeader('Location', '/users-list')
            ->withStatus(302);
    }
}