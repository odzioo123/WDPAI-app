<?php


use models\Course;
use repository\Repository;

require_once 'Repository.php';
require_once __DIR__.'/../models/Course.php';
class CoursesRepository extends Repository
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
}
