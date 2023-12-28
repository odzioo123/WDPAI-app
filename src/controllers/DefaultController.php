<?php

require_once 'AppController.php';
class DefaultController extends AppController {

    public function home()
    {
        $this->render('home');
    }
    public function index() //TODO moze psuc, zmien na index
    {
        $this->render('login', ['messages' => ["Hello World!", "XDDDD"]]);
    }
    public function registration()
    {
        $this->render('registration');
    }
    public function menu()
    {
        $this->render('menu');
    }
    public function plan()
    {
        $this->render('plan');
    }
    public function forum()
    {
        $this->render('forum');
    }
    public function announcements()
    {
        $this->render('announcements');
    }
    public function addProject()
    {
        $this->render('addProject');
    }
}