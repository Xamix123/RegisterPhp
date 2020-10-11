<?php

namespace testTask1\app\components;

use http\Header;
use testTask1\app\view\View;

class Router
{
    private $routes;

    /**
     * Router constructor.
     */
    public function __construct()
    {
        $routesPath = ROOT.'/app/config/routes.php';

        $this->routes = include $routesPath;
    }

    /**
     * @return string
     */
    private function getURI()
    {
        if (! empty($_SERVER['REQUEST_URI'])) {
            return trim($_SERVER['REQUEST_URI'], '/');
        }
    }


    public function run()
    {
        $uri =  $this->getURI(); // get rout

        foreach ($this->routes as $uriPattern => $path) {
            // check file routes.php
            if (preg_match("~$uriPattern~", $uri)) {
                //route from routes
                $internalRoute = preg_replace("~$uriPattern~", $path, $uri);

                $segments = explode('/', $internalRoute);

                //get controller name from path
                $controllerName = array_shift($segments).'Controller';
                $controllerName = ucfirst($controllerName);

                //get action name from path
                $actionName = 'action'.ucfirst(array_shift($segments));
                $parameters = $segments;

                $controllerFile = ROOT. '/app/controllers/'. $controllerName .'.php';
                if (file_exists($controllerFile)) {
                    include_once $controllerFile;
                }

                $namespace = "testTask1\app\controllers";
                $controllerName = $namespace . '\\' . $controllerName;

                $controllerObject = new $controllerName;

                try {
                    $result = call_user_func_array(
                        [$controllerObject, $actionName],
                        $parameters
                    );

                    if ($result == null) {
                        throw new \Exception("Page does not exist", 404);
                    }
                } catch (\Exception $e) {
                    include_once( ROOT . '/app/resources/views/errors/err404.php');
                }

                if ($result != null) {
                    break;
                }
            }
        }
    }
}
