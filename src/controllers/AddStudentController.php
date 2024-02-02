<?php

use models\User;

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
require_once __DIR__.'/../repository/UserRepository.php';

class AddStudentController extends AppController
{
    public function addStudentProcess()
    {
        if ($this->isPost())
        {
            $email = $_POST['email'];

            $userRepository = new UserRepository();
            if ($userRepository->getUser($email)) {
                $this->render('addStudent', ['error' => 'User with this email already exists.']);
                return;
            }

            $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
            $name = $_POST['name'];
            $surname = $_POST['surname'];

            $newUser = new User(-1, $email, $password, 2, $name, $surname);

            $userRepository = new UserRepository();
            $success = $userRepository->addUser($newUser);

            if ($success)
            {
                session_start();
                $this->render('menu');
            } else
            {
                $this->render('addStudent', ['error' => 'Failed to add user.']);
            }
        }
        else
        {
            session_start();
            $this->render('menu');
        }
    }

}
