<?php
declare(strict_types=1);

namespace App;

class Config
{
    protected array $data;
    protected array $descriptions;

    public function __construct()
    {
        foreach((include __DIR__ . '/../config/database.php') as $key => $value){
            $this->data[$key] = $value;
        }

        foreach ((include __DIR__ . '/../config/actionDescription.php') as $key => $value) {
            $this->descriptions[$key] = $value;
        }
    }

    /**
     * Return Database data
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Return descriptions
     * @return array
     */
    public function getDesc(): array
    {
        return $this->descriptions;
    }
}