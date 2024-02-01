<?php

require_once 'src/controllers/DefaultController.php';
require_once 'src/controllers/SecurityController.php';
require_once 'src/controllers/ProjectController.php';
require_once 'src/controllers/AddStudentController.php';
require_once 'src/controllers/AddUserToGroupController.php';
require_once 'src/controllers/PlanController.php';
require_once 'src/controllers/AddCourseController.php';
require_once 'src/controllers/AddGroupToCourseController.php';

class Routing {
    public static $routes;

    public static function get($url, $controller)
    {
        self::$routes[$url] = $controller;
    }

    public static function post($url, $controller)
    {
        self::$routes[$url] = $controller;
    }

    public static function run($url)
    {
        $action = explode("/", $url)[0];

        if(!array_key_exists($action, self::$routes))
        {
            $controller = new DefaultController();
            $controller->home();
            exit;
        }
        $controller = self::$routes[$action];
        $object = new $controller;

        $object->$action();
    }


}


