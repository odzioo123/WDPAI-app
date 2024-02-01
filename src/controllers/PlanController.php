<?php


use repository\GroupRepository;

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/GroupRepository.php';
require_once __DIR__.'/../repository/CourseRepository.php';
class PlanController extends AppController
{
    public function plan()
    {
        session_start();

        if (!isset($_SESSION['Admin']) && !isset($_SESSION['Student']))
        {
            header('Location: login');
            exit();
        }

        if(isset($_SESSION['Admin']))
        {
            $userID = $_SESSION['Admin'];
        }
        else
        {
            $userID = $_SESSION['Student'];
        }

        $userRepository = new UserRepository();
        $user = $userRepository->getUserById($userID);

        if ($user === null)
        {
            $this->render('login', ['error' => 'User not found.']);
            return;
        }

        $groupRepository = new GroupRepository();
        $userGroups = $groupRepository->getGroupsByUserID($userID);

        if (empty($userGroups))
        {
            $this->render('error', ['error' => 'User is not assigned to any group.']);
            return;
        }

        $coursesRepository = new CourseRepository();
        $uniqueCourses = [];

        foreach ($userGroups as $group)
        {
            $groupCourses = $coursesRepository->getCoursesByGroupID($group->getGroupID());

            foreach ($groupCourses as $course) {
                // Use course ID as the key to ensure uniqueness
                $uniqueCourses[$course->getCourseID()] = $course;
            }
        }

        $uniqueCourses = array_values($uniqueCourses);

        $this->render('plan', ['courses' => $uniqueCourses]);
    }
}
