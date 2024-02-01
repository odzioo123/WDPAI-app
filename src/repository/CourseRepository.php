<?php

use models\Course;
use repository\GroupRepository;
use repository\Repository;

require_once 'Repository.php';
require_once __DIR__.'/../models/Course.php';
require_once 'GroupRepository.php';

class CourseRepository extends Repository
{
    public function getCoursesByGroupID(int $groupID): array
    {
        $stmt = $this->database->connect()->prepare('
            SELECT c.*
            FROM public."Courses" c
            JOIN public."GroupsToCourses" gc ON c."CourseID" = gc."CourseID"
            WHERE gc."GroupID" = :groupID
        ');

        $stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);
        $stmt->execute();

        $courses = [];

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $courses[] = new Course(
                $row['CourseID'],
                $row['Course_name'],
                $row['Course_start'],
                $row['Course_end'],
                $row['Day'],
                $row['Lecturer']
            );
        }

        return $courses;
    }

    public function getCourseByName(string $courseName): ?Course
    {
        $stmt = $this->database->connect()->prepare('
        SELECT *
        FROM public."Courses"
        WHERE "Course_name" = :courseName
    ');

        $stmt->bindParam(':courseName', $courseName, PDO::PARAM_STR);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) {
            return null;
        }

        return new Course(
            $row['CourseID'],
            $row['Course_name'],
            $row['Course_start'],
            $row['Course_end'],
            $row['Day'],
            $row['Lecturer']
        );
    }

    public function addCourse(string $courseName, string $courseStart, string $courseEnd, string $day, string $lecturer): bool
    {
        $stmt = $this->database->connect()->prepare('
            INSERT INTO public."Courses" ("Course_name", "Course_start", "Course_end", "Day", "Lecturer")
            VALUES (:courseName, :courseStart, :courseEnd, :day, :lecturer)
        ');

        $stmt->bindParam(':courseName', $courseName, PDO::PARAM_STR);
        $stmt->bindParam(':courseStart', $courseStart, PDO::PARAM_STR);
        $stmt->bindParam(':courseEnd', $courseEnd, PDO::PARAM_STR);
        $stmt->bindParam(':day', $day, PDO::PARAM_STR);
        $stmt->bindParam(':lecturer', $lecturer, PDO::PARAM_STR);

        try {
            return $stmt->execute();
        } catch (PDOException $e)
        {
            echo 'Error: ' . $e->getMessage();
            return false;
        }
    }

    public function addGroupToCourse(int $courseID, int $groupID): bool
    {
        try {
            if ($this->isGroupAlreadyAddedToCourse($courseID, $groupID))
            {
                return true;
            }

            $stmt = $this->database->connect()->prepare('
            INSERT INTO public."GroupsToCourses" ("CourseID", "GroupID")
            VALUES (:courseID, :groupID)
        ');

            $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
            $stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);

            return $stmt->execute();
        } catch (PDOException $e) {
            echo 'Error adding group to course: ' . $e->getMessage();
            return false;
        }
    }

    private function isGroupAlreadyAddedToCourse(int $courseID, int $groupID): bool
    {
        $stmt = $this->database->connect()->prepare('
        SELECT COUNT(*) as count
        FROM public."GroupsToCourses"
        WHERE "CourseID" = :courseID AND "GroupID" = :groupID
    ');

        $stmt->bindParam(':courseID', $courseID, PDO::PARAM_INT);
        $stmt->bindParam(':groupID', $groupID, PDO::PARAM_INT);
        $stmt->execute();

        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        return ($result && $result['count'] > 0);
    }
}
