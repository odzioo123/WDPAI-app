<?php

namespace models;

class Course
{
    private $courseID;
    private $courseName;
    private $courseStart;
    private $courseEnd;
    private $day;
    private $lecturer;

    public function __construct(
        int $courseID,
        string $courseName,
        string $courseStart,
        string $courseEnd,
        string $day,
        string $lecturer
    ) {
        $this->courseID = $courseID;
        $this->courseName = $courseName;
        $this->courseStart = $courseStart;
        $this->courseEnd = $courseEnd;
        $this->day = $day;
        $this->lecturer = $lecturer;
    }

    public function getCourseID(): int
    {
        return $this->courseID;
    }

    public function getCourseName(): string
    {
        return $this->courseName;
    }

    public function getCourseStart(): string
    {
        return $this->courseStart;
    }

    public function getCourseEnd(): string
    {
        return $this->courseEnd;
    }

    public function getDay(): string
    {
        return $this->day;
    }

    public function getLecturer(): string
    {
        return $this->lecturer;
    }
}
