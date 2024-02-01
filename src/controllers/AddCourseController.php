<?php

require_once 'AppController.php';
require_once __DIR__.'/../repository/CourseRepository.php';

class AddCourseController extends AppController
{
    public function addCourse()
    {
        session_start();

        if (!isset($_SESSION['Admin'])) {
            header('Location: login');
            exit();
        }

        if ($this->isPost()) {
            $courseName = $_POST['courseName'];
            $courseStart = $_POST['courseStart'];
            $courseEnd = $_POST['courseEnd'];
            $day = $_POST['day'];
            $lecturer = $_POST['lecturer'];

            $coursesRepository = new CourseRepository();
            $success = $coursesRepository->addCourse($courseName, $courseStart, $courseEnd, $day, $lecturer);


            if ($success) {
                $this->render('menu', ['message' => 'Course added successfully.']);
                return;
            } else {
                $this->render('addCourse', ['error' => 'Failed to add the course.']);
                return;
            }
        }

        $this->render('addCourse');
    }
}
