<?php
declare(strict_types=1);

namespace Controller;

use App\Controller;
use CustomExp\AddException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Repository\UserRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class AddUserController extends Controller
{

    /**
     * @param Request $request
     * @param Response $response
     * @return Response
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    public function viewLogin(Request $request, Response $response): Response
    {
        $body = $this->getTwig()->render('addUser.twig', [
            'message' => $this->getSession()->flush('message'),
            'form' => $this->getSession()->flush('form'),
            'user' => $this->getSession()->getData('user')
        ]);
        $response->getBody()->write($body);

        return $response;
    }

    /**
     *
     * @param Request $request
     * @param Response $response
     * @return Response
     */
    public function addUser(Request $request, Response $response): Response
    {
        $userRepo = new UserRepository();
        $params = (array)$request->getParsedBody();

        try {
            $userRepo->addNewUser($params, $this->getDatabase());

        } catch (AddException $exception) {
            $this->getSession()->setData('message', $exception->getMessage());
            $this->getSession()->setData('form', $params);
            return $response->withHeader('Location', '/add-user')
                ->withStatus(302);
        }

        return $response->withHeader('Location', '/users-list')
            ->withStatus(302);
    }
}