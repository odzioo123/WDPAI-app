<?php

namespace repository;

use models\Group;
use PDO;
use repository\Repository;

require_once 'Repository.php';
require_once __DIR__.'/../models/Group.php';
class GroupRepository extends Repository
{
    public function getGroupsByUserID(int $userID): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT g.*
            FROM public."UserToGroup" ug
            JOIN public."Groups" g ON ug."GroupID" = g."GroupID"
            WHERE ug."UserID" = :userID
        ');

        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        $groups = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC))
        {
            $groups[] = new Group(
                $row['GroupID'],
                $row['GroupName']
            );
        }

        return $groups;
    }

    public function getGroupById(int $groupId): ?Group
    {
        $stmt = $this->database->connect()->prepare('
            SELECT *
            FROM public."Groups"
            WHERE "GroupID" = :groupId
        ');

        $stmt->bindParam(':groupId', $groupId, PDO::PARAM_INT);
        $stmt->execute();

        $groupData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($groupData === false) {
            return null;
        }

        return new Group($groupData['GroupID'], $groupData['GroupName']);
    }

    public function getGroupByName(string $groupName): ?Group
    {
        $stmt = $this->database->connect()->prepare('
        SELECT *
        FROM public."Groups"
        WHERE "GroupName" = :groupName
    ');

        $stmt->bindParam(':groupName', $groupName, PDO::PARAM_STR);
        $stmt->execute();

        $groupData = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($groupData === false) {
            return null;
        }

        return new Group($groupData['GroupID'], $groupData['GroupName']);
    }

    public function addUserToGroup(int $userID, int $groupID): bool
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."UserToGroup" ("UserID", "GroupID")
            VALUES (:userID, :groupID)
        ');

        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);

        return $stmt->execute();
    }

    public function getGroupByUserID(int $userID): ?Group
    {
        $stmt = $this->database->connect()->prepare('
            SELECT g.*
            FROM public."Groups" g
            JOIN public."UserToGroup" u2g ON g."GroupID" = u2g."GroupID"
            WHERE u2g."UserID" = :userID
        ');

        $stmt->bindParam(':userID', $userID, PDO::PARAM_INT);
        $stmt->execute();

        $groupData = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$groupData) {
            return null;
        }

        return new Group(
            $groupData['GroupID'],
            $groupData['GroupName']
        );
    }
}
