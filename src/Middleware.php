<?php
declare(strict_types=1);

namespace App;

abstract class Middleware
{
    private Database $database;
    private Session $session;

    public function __construct()
    {
        $this->session = new Session();
        $this->database =  new Database();

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