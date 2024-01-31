<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('home', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('registration', 'DefaultController');
Routing::get('menu', 'DefaultController');
Routing::get('plan', 'DefaultController');
Routing::get('forum', 'DefaultController');
Routing::get('announcements', 'DefaultController');

Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');

Routing::get('addStudent', 'DefaultController');
Routing::post('addStudentProcess', 'AddStudentController');

Routing::get('addProject', 'DefaultController');
Routing::post('addProject', 'ProjectController');


Routing::run($path);


