<?php

namespace models;

class User
{
    private $userID;
    private $email;
    private $password;
    private $role;
    private $name;
    private $surname;

    public function __construct(
        int $userID,
        string $email,
        string $password,
        int $role,
        string $name,
        string $surname
    ) {
        $this->userID = $userID;
        $this->email = $email;
        $this->password = $password;
        $this->role = $role;
        $this->name = $name;
        $this->surname = $surname;
    }

    public function getUserID(): int
    {
        return $this->userID;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setRole(int $role)
    {
        $this->role = $role;
    }

    public function getRole(): int
    {
        return $this->role;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setSurname(string $surname)
    {
        $this->surname = $surname;
    }

    public function getSurname(): string
    {
        return $this->surname;
    }
}
