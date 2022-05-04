<?php

declare(strict_types=1);

use Phoenix\Migration\AbstractMigration;

final class Users extends AbstractMigration
{
    protected function up(): void
    {
        $this->execute('CREATE TABLE `users` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                `login` varchar(255) NOT NULL,
                `password` varchar(255) NOT NULL,
                `access_status` tinyint NOT NULL DEFAULT 1,
                `role` varchar(255) NOT NULL,
                PRIMARY KEY (`id`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;'
        );
    }

    protected function down(): void
    {
        $this->execute('DROP TABLE `users`');

    }
}
