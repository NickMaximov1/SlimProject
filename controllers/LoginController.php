<?php
declare(strict_types=1);

namespace Controller;

use App\Controller;
use CustomExp\LoginException;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Repository\UserRepository;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class LoginController extends Controller
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
        $body = $this->getTwig()->render('login.twig', [
            'message' => $this->getSession()->flush('message'),
            'form' => $this->getSession()->flush('form'),
            'user' => $this->getSession()->getData('user')
        ]);
        $response->getBody()->write($body);

        return $response;
    }

    public function loginPost(Request $request, Response $response): Response
    {
        $userRepo = new UserRepository();
        $params = $request->getParsedBody();
        try {
            $userRepo->login($params['login'], $params['password'], $this->getDatabase(), $this->getSession());
        } catch (LoginException $exception) {
            $this->getSession()->setData('message', $exception->getMessage());
            $this->getSession()->setData('form', $params);

            return $response->withHeader('Location', '/login')
                ->withStatus(302);
        }

        return $response->withHeader('Location', '/')
            ->withStatus(302);
    }

    public function logOut(Request $request, Response $response): Response
    {
        $this->getSession()->setData('user', null);

        return $response->withHeader('Location', '/')
            ->withStatus(302);
    }
}