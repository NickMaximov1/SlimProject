<?php
declare(strict_types=1);

namespace App;

class Session
{
    /**
     * start of session
     * @return void
     */
    public function start(): void
    {
        session_start();
    }

    /**
     * Set data
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public function setData(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Return data by key
     * @param string $key
     * @return mixed
     */
    public function getData(string $key): mixed
    {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    /**
     * Write session data and end session
     * @return void
     */
    public function save(): void
    {
        session_write_close();
    }

    /**
     * Delete data from $_SESSION by key and return value
     * @param string $key
     * @return mixed
     */
    public function flush(string $key): mixed
    {
        $value = $this->getData($key);
        $this->unset($key);

        return $value;
    }

    /**
     * Unset data from $_SESSION by key
     * @param string $key
     * @return void
     */
    private function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }
}