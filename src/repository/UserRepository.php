<?php

use models\User;
use repository\Repository;

require_once 'Repository.php';
require_once __DIR__.'/../models/User.php';
class UserRepository extends Repository
{
    public function getUser(string $email): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.*, ud."Name", ud."Surname"
            FROM public."Users" u
            JOIN public."UsersDetails" ud ON u."UserID" = ud."UserID"
            WHERE u."Email" = :email
        ');
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['UserID'],
            $user['Email'],
            $user['Password'],
            $user['Role'],
            $user['Name'],
            $user['Surname']
        );
    }

    public function getUserById(int $userID): ?User
    {
        $stmt = $this->database->connect()->prepare('
            SELECT u.*, ud."Name", ud."Surname"
            FROM public."Users" u
            JOIN public."UsersDetails" ud ON u."UserID" = ud."UserID"
            WHERE u."UserID" = :userID
        ');

        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user == false) {
            return null;
        }

        return new User(
            $user['UserID'],
            $user['Email'],
            $user['Password'],
            $user['Role'],
            $user['Name'],
            $user['Surname']
        );
    }

    public function addUser(User $user): bool
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO public."Users" ("Email", "Password", "Role")
        VALUES (:email, :password, :role)
        RETURNING "UserID"
    ');

        $email = $user->getEmail();
        $password = $user->getPassword();
        $role = $user->getRole();

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);

        $result = $stmt->execute();

        if (!$result) {
            return false;
        }

        $userID = $stmt->fetchColumn();

        $stmtDetails = $this->database->connect()->prepare('
        INSERT INTO public."UsersDetails" ("UserID", "Name", "Surname")
        VALUES (:userID, :name, :surname)
    ');

        $name = $user->getName();
        $surname = $user->getSurname();

        $stmtDetails->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmtDetails->bindParam(':name', $name, PDO::PARAM_STR);
        $stmtDetails->bindParam(':surname', $surname, PDO::PARAM_STR);

        return $stmtDetails->execute();
    }
}