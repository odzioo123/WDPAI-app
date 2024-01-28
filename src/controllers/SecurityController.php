<?php


use models\User;

require_once __DIR__.'/../repository/UserRepository.php';
require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
class SecurityController extends AppController
{
    public function login()
    {
        if(!$this->isPost())
        {
            return $this->render('login');
        }

        $email = $_POST["email"];
        $password = $_POST["password"];
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $userRepository = new UserRepository();

//        $user2 = new User(2,'ddd', password_hash('zzz', PASSWORD_BCRYPT), 1, 1, 'zzz', 'zzz');
//        $userRepository->addUser($user2);

        $user = $userRepository->getUser($email);

        if(!$user)
        {
            return $this->render('login', ['messages' => ['User not exist']]);
        }

        if($user->getEmail() !== $email)
        {
            return $this->render('login', ['messages' => ['User with this email don\'t exist']]);
        }

        if(password_verify($user->getPassword(), $hash))
        {
            return $this->render('login', ['messages' => ['Wrong data provided']]);
        }

        return $this->render('menu');

//        $url = "http://$_SERVER[HTTP_HOST]";
//        header("Location: {$url}/menu");
    }
}