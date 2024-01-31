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
            $user['GroupID'],
            $user['Role'],
            $user['Name'],
            $user['Surname']
        );
    }

    public function addUser(User $user): bool
    {
        $stmt = $this->database->connect()->prepare('
        INSERT INTO public."Users" ("Email", "Password", "GroupID", "Role")
        VALUES (:email, :password, :groupID, :role)
        RETURNING "UserID"
    ');

        $email = $user->getEmail();
        $password = $user->getPassword();
        $groupID = $user->getGroupID();
        $role = $user->getRole();

        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':password', $password, PDO::PARAM_STR);
        $stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);
        $stmt->bindParam(':role', $role, PDO::PARAM_INT);

        // Execute the query
        $result = $stmt->execute();

        // Check if the query was successful
        if (!$result) {
            return false;
        }

        // Retrieve the last inserted user ID directly from the RETURNING clause
        $userID = $stmt->fetchColumn();

        // Insert user details into the users_details table
        $stmtDetails = $this->database->connect()->prepare('
        INSERT INTO public."UsersDetails" ("UserID", "Name", "Surname")
        VALUES (:userID, :name, :surname)
    ');

        $name = $user->getName();
        $surname = $user->getSurname();

        $stmtDetails->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmtDetails->bindParam(':name', $name, PDO::PARAM_STR);
        $stmtDetails->bindParam(':surname', $surname, PDO::PARAM_STR);

        // Execute the details query
        $resultDetails = $stmtDetails->execute();

        // Return the overall result
        return $resultDetails;
    }
}