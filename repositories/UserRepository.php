<?php
declare(strict_types=1);

namespace Repository;

use App\Database;
use App\Session;
use CustomExp\AddException;
use CustomExp\LoginException;
use Model\User;

class UserRepository
{
    public function getAllUsers(Database $database): array
    {
        $usersArr = $database->query(
            sql: 'SELECT * FROM `users` ORDER BY `role`',
            class: User::class);
        return !empty($usersArr) ? $usersArr : throw new \PDOException('Can`t find users');
    }

    public function blockUnblockUser(array $form, Database $database): bool
    {
        $id = array_key_first($form);
        $accessStatus = 0;

        if ($form[$id] == 'unblock') {
            $accessStatus = 1;
        }
        $sql = 'UPDATE `users`
                SET `access_status` = :access_status
                WHERE `id` = :id';
        $data = [
            'access_status' => $accessStatus,
            'id' => $id];

        return $database->save($sql, $data);
    }

    public function addNewUser(array $params, Database $database): bool
    {
        if (empty($params['login'])) {
            throw new AddException('The Username should not be empty');
        }

        if (empty($params['password'])) {
            throw new AddException('The Password should not be empty');
        }

        if ($params['password'] !== $params['confirm_password']) {
            throw new AddException('The Passwords and Confirm Password should match');
        }

        $usersArr = $database->query(
            sql: 'SELECT * FROM `users` WHERE `login` = :login',
            class: User::class,
            data: ['login' => $params['login']]);

        if(null !== $usersArr){
            throw new AddException('User with such login exists');
        }

        $sql = 'INSERT INTO `users` (`login`, `password`, `role`) 
                    VALUES (:login, :password, :role)';
        $data = [
            'login' => $params['login'],
            'password' => password_hash($params['password'], PASSWORD_BCRYPT),
            'role' => $params['role']];

        return $database->save($sql, $data);
    }


    public function login(string $login, string $password, Database $database, Session $session): bool
    {
        if (empty($login)) {
            throw new LoginException('The Username should not be empty');
        }

        if (empty($password)) {
            throw new LoginException('The Password should not be empty');
        }
        $usersArr = $database->query(
            sql: 'SELECT * FROM `users` WHERE `login` = :login',
            class: User::class,
            data: ['login' => $login]);

        if (null === $usersArr) {
            throw new LoginException('User with such login not found');
        }

        $user = $usersArr[0];

        if (1 != $user->getAccessStatus()) {
            throw new LoginException('You can`t log in, because you didn`t support Ukraine');
        }

        if (password_verify($password, $user->getPassword())) {
            $session->setData('user', [
                'id' => $user->getId(),
                'login' => $user->getLogin(),
                'role' => $user->getRole()]);

            return true;
        }
        throw new LoginException('Incorrect login or password');
    }
}