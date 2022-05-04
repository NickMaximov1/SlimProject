<?php
declare(strict_types=1);

namespace Repository;

use App\Database;
use Model\Action;

class ActionRepository
{
    private float $start = 0.;

    public function getAllActions(Database $database): array
    {
        $actionsArr = $database->query(
            sql: 'SELECT * FROM `log_actions` ORDER BY `id` DESC',
            class: Action::class,
            data: []);
        return !empty($actionsArr) ? $actionsArr : throw new \PDOException('Can`t find users');
    }

    public function addAction(string $login, string $ip, string $action, float $timeRunning, Database $database): bool
    {
        $sql = 'INSERT INTO `log_actions`
                (`login`, `ip`, `action`, `time_running`)
                VALUES (:login, :ip, :action, :time_running)';
        $data = [
            'login' => $login,
            'ip' => $ip,
            'action' =>$action,
            'time_running' => $timeRunning
        ];
        $database->save($sql, $data);

        return true;
    }

    public function start(): void
    {
        $this->start = microtime(true);
    }

    public function finish(): float
    {
        return microtime(true) - $this->start;
    }
}