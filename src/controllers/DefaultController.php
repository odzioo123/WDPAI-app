<?php

require_once 'AppController.php';
class DefaultController extends AppController {

    public function index()
    {
        //TODO display login.html
        $this->render('home');
    }
    public function login()
    {
        //TODO display login.html
        $this->render('login');
    }
    public function registration()
    {
        //TODO display register.html
        $this->render('registration');
    }
    public function menu()
    {
        //TODO display register.html
        $this->render('menu');
    }
    public function projects()
    {
        //TODO display projects.html
        $this->render('projects');
    }
}