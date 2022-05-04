<?php

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

    public function getTwig(): Environment
    {
        return $this->twig;
    }

    public function getDatabase(): Database
    {
        return $this->database;
    }

    public function getSession(): Session
    {
        return $this->session;
    }

}