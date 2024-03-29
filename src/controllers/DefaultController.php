<?php

use models\Announcement;

require_once 'AppController.php';
require_once __DIR__.'/../models/Announcement.php';
class DefaultController extends AppController {

    public function home()
    {
        $this->render('login');
    }
    public function login()
    {
        $this->render('login');
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

    public function addStudent()
    {
        session_start();
        if (isset($_SESSION['Admin']))
        {
            $this->render('addStudent');
        }
        else
        {
            $this->render('login');
        }
    }

    public function addUserToGroup()
    {
        session_start();
        if (isset($_SESSION['Admin']))
        {
            $this->render('addUserToGroup');
        }
        else
        {
            $this->render('login');
        }
    }

    public function addCourse()
    {
        session_start();
        if (isset($_SESSION['Admin']))
        {
            $this->render('addCourse');
        }
        else
        {
            $this->render('login');
        }
    }

    public function addGroupToCourse()
    {
        session_start();
        if (isset($_SESSION['Admin']))
        {
            $this->render('addGroupToCourse');
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