<?php

require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('home', 'DefaultController');
Routing::get('login', 'DefaultController');
Routing::get('registration', 'DefaultController');
Routing::get('menu', 'DefaultController');
Routing::get('plan', 'PlanController');
Routing::get('forum', 'DefaultController');

Routing::get('announcements', 'AnnouncementsController');

Routing::post('login', 'SecurityController');
Routing::post('logout', 'SecurityController');

Routing::get('addStudent', 'DefaultController');
Routing::post('addStudentProcess', 'AddStudentController');

Routing::get('addProject', 'DefaultController');
Routing::post('addProject', 'ProjectController');

Routing::get('addUserToGroup', 'DefaultController');
Routing::post('addUserToGroupProcess', 'AddUserToGroupController');

Routing::get('addCourse', 'DefaultController');
Routing::post('addCourse', 'AddCourseController');

Routing::get('addGroupToCourse', 'DefaultController');
Routing::post('addGroupToCourse', 'AddGroupToCourseController');

Routing::run($path);


