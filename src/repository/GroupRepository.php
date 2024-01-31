<?php

namespace repository;

use models\Group;
use PDO;
use repository\Repository;

require_once 'Repository.php';
require_once __DIR__.'/../models/Group.php';
class GroupRepository extends Repository
{
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
}
