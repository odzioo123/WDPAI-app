<?php

use models\Announcement;

require_once 'AppController.php';
require_once __DIR__.'/../models/Announcement.php';
class DefaultController extends AppController {

    public function home()
    {
        $this->render('home');
    }
    public function login()
    {
        $this->render('login', ['messages' => ["Hello World!"]]);
    }
    public function registration()
    {
        $this->render('registration');
    }
    public function menu()
    {
        session_start();
        if (isset($_SESSION['Admin']) || isset($_SESSION['Student']))
        {
            $this->render('menu');
        }
        else
        {
            $this->render('login');
        }
    }
    public function plan()
    {
        session_start();
        if (isset($_SESSION['Admin']) || isset($_SESSION['Student']))
        {
            $this->render('plan');
        }
        else
        {
            $this->render('login');
        }
    }
    public function forum()
    {
        session_start();
        if (isset($_SESSION['Admin']) || isset($_SESSION['Student']))
        {
            $this->render('forum');
        }
        else
        {
            $this->render('login');
        }
    }
    public function announcements()
    {
        session_start();
        if (isset($_SESSION['Admin']) || isset($_SESSION['Student']))
        {
            $this->render('announcements');
        }
        else
        {
            $this->render('login');
        }
    }
    public function addProject()
    {
        $this->render('addProject');
    }
}