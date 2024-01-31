<?php

use repository\GroupRepository;

require_once 'AppController.php';
require_once __DIR__.'/../repository/UserRepository.php';
require_once __DIR__.'/../repository/GroupRepository.php';

class AddUserToGroupController extends AppController
{
    public function addUserToGroupProcess()
    {
        if ($this->isPost())
        {
            $userEmail = $_POST['userEmail'];
            $groupName = $_POST['groupName'];

            $userRepository = new UserRepository();
            $groupRepository = new GroupRepository();

            $user = $userRepository->getUser($userEmail);
            $group = $groupRepository->getGroupByName($groupName);

            if ($user && $group) {
                $success = $groupRepository->addUserToGroup($user->getUserID(), $group->getGroupID());

                if ($success)
                {
                    session_start();
                    $this->render('menu');
                    return;
                }
                else
                {
                    session_start();
                    $this->render('addUserToGroup', ['error' => 'Failed to add user to group.']);
                    return;
                }
            } else
            {
                session_start();
                $this->render('addUserToGroup', ['error' => 'User or group not found.']);
                return;
            }
        }
        session_start();
        $this->render('menu', ['message' => 'Invalid request.']);
    }
}
