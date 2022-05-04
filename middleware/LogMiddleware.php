<?php
declare(strict_types=1);

namespace Middleware;

use App\Config;
use App\Middleware;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RHI;
use Repository\ActionRepository;

class LogMiddleware extends Middleware
{
    public function __invoke(Request $request, RHI $handler): Response
    {
        $config = new Config();
        $actionRepo = new ActionRepository();
        $descriptions = $config->getDesc();
        $actionRepo->start();
        $url = $request->getUri()->getPath();
        $response = $handler->handle($request);
        $timeRunning = $actionRepo->finish();

        if (!empty($this->getSession()->getData('user'))) {
            $actionRepo->addAction($this->getSession()->getData('user')['login'],
                $_SERVER['REMOTE_ADDR'],
                $descriptions[$url],
                $timeRunning, $this->getDatabase());
        } else {
            $actionRepo->addAction('Unknown user',
                $_SERVER['REMOTE_ADDR'],
                $descriptions[$url],
                $timeRunning, $this->getDatabase());
        }

        return $response;
    }
}