
<?php
//        echo 'Hola mi amigo <3';
require 'Routing.php';

$path = trim($_SERVER['REQUEST_URI'], '/');
$path = parse_url($path, PHP_URL_PATH);

Routing::get('home', 'DefaultController');
Routing::get('index', 'DefaultController');
Routing::get('registration', 'DefaultController');
Routing::get('menu', 'DefaultController');
Routing::get('plan', 'DefaultController');
Routing::get('forum', 'DefaultController');
Routing::get('announcements', 'DefaultController');

Routing::post('login', 'SecurityController');

Routing::get('addProject', 'DefaultController');
Routing::post('addProject', 'ProjectController');

Routing::run($path);




