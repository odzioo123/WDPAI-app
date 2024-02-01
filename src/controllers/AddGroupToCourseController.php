<?php

use repository\GroupRepository;

require_once 'AppController.php';
require_once __DIR__.'/../repository/GroupRepository.php';
require_once __DIR__.'/../repository/CourseRepository.php';

class AddGroupToCourseController extends AppController
{
    public function addGroupToCourse()
    {
        if ($this->isPost())
        {
            $groupName = $_POST['groupName'];
            $courseName = $_POST['courseName'];

            $groupRepository = new GroupRepository();
            $courseRepository = new CourseRepository();

            $group = $groupRepository->getGroupByName($groupName);
            $course = $courseRepository->getCourseByName($courseName);

            if ($group && $course)
            {
                $success = $courseRepository->addGroupToCourse($course->getCourseID(), $group->getGroupID());

                if ($success)
                {
                    session_start();
                    header('Location: plan');
                    return;
                }
                else
                {
                    session_start();
                    $this->render('addGroupToCourse', ['error' => 'Failed to add group to course.']);
                    return;
                }
            } else
            {
                session_start();
                $this->render('addGroupToCourse', ['error' => 'Group or course not found.']);
                return;
            }
        }

        $this->render('addGroupToCourse');
    }

}
