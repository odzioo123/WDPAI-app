<?php

namespace models;

class Group
{
    private $groupID;
    private $groupName;

    public function __construct(int $groupID, string $groupName)
    {
        $this->groupID = $groupID;
        $this->groupName = $groupName;
    }

    public function getGroupID(): int
    {
        return $this->groupID;
    }

    public function setGroupName(string $groupName)
    {
        $this->groupName = $groupName;
    }

    public function getGroupName(): string
    {
        return $this->groupName;
    }
}
