<?php

declare(strict_types=1);

use Phoenix\Migration\AbstractMigration;

final class Actions extends AbstractMigration
{
    protected function up(): void
    {
        $this->execute('CREATE TABLE `log_actions` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP, 
                `login` varchar(255) NOT NULL,
                `ip` varchar(255) NOT NULL,
                `action` varchar(255) NOT NULL DEFAULT 1,
                `time_running` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
        
    }

    protected function down(): void
    {
        $this->execute('DROP TABLE `log_actions`');
    }
}
