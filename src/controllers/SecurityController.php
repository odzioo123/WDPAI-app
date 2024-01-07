<?php

use models\User;

require_once 'AppController.php';
require_once __DIR__.'/../models/User.php';
class SecurityController extends AppController
{
    public function login()
    {
        $user = new User('admin', 'admin', 'john', 'smith');

        if(!$this->isPost())
        {
            return $this->render('login');
        }
        $email = $_POST["email"];
        $password = $_POST["password"];

        if($user->getEmail() !== $email)
        {
            return $this->render('login', ['messages' => ['User with this email don\'t exist']]);
        }

        if($user->getPassword() !== $password)
        {
            return $this->render('login', ['messages' => ['Wrong data provided']]);
        }

        return $this->render('menu');

//        $url = "http://$_SERVER[HTTP_HOST]";
//        header("Location: {$url}/menu");
    }
}