<?php
declare(strict_types=1);

namespace App;

class Session
{
    public function start(): void
    {
        session_start();
    }

    public function setData(string $key, mixed $value): void
    {
        $_SESSION[$key] = $value;
    }

    public function getData(string $key): mixed
    {
        return !empty($_SESSION[$key]) ? $_SESSION[$key] : null;
    }

    public function save(): void
    {
        session_write_close();
    }

    public function flush(string $key): mixed
    {
        $value = $this->getData($key);
        $this->unset($key);

        return $value;
    }

    private function unset(string $key): void
    {
        unset($_SESSION[$key]);
    }

}