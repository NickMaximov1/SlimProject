<?php
declare(strict_types=1);

namespace App;

use Twig\Environment;
use Twig\Loader\FilesystemLoader;

abstract class Controller
{
    private Environment $twig;
    private Database $database;
    private Session $session;

    public function __construct()
    {
        $this->twig = new Environment(new FilesystemLoader('templates'));
        $this->session = new Session();
        $this->database =  new Database();

    }

    /**
     * Return Environment
     * @return Environment
     */
    public function getTwig(): Environment
    {
        return $this->twig;
    }

    /**
     * Return Database
     * @return Database
     */
    public function getDatabase(): Database
    {
        return $this->database;
    }

    /**
     * Return Session
     * @return Session
     */
    public function getSession(): Session
    {
        return $this->session;
    }

}