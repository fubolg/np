<?php
namespace App\Core;

class Router
{
    /**
     * @var array
     */
    private $routes;

    private $container;

    /**
     * Router constructor.
     *
     * @param Container $container
     */
    public function __construct($container)
    {
        $this->container = $container;
    }

    public function route()
    {
        $this->init();

        $requestMethod = $_SERVER['REQUEST_METHOD'];
        $scriptUrl = isset($_SERVER['SCRIPT_URL']) ? $_SERVER['SCRIPT_URL'] : '/';
        $explodedRoute = explode('/', $scriptUrl);
        $routes = isset($this->routes[$requestMethod]) ? $this->routes[$requestMethod] : [];

        foreach ($routes as $route) {
            if (isset($route['route']) && !empty($route['route'])) {
                $preg_sub_str = str_replace('/', '\/', preg_replace('/\{(.*)\}/','([0-9]+)',$route['route']));
            } else {
                throw new \Exception("Required parameter \"route\" is not set for this rule!");
            }

            if (preg_match('/^' . $preg_sub_str .'\/?$/',$scriptUrl)) {
                $explodeRule = explode('/',$route['route']);
                $methodParams = preg_grep('/\{(.*)\}/', $explodeRule);
                $params = [];

                foreach ($methodParams as $key => $param) {
                    $params[] = $explodedRoute[$key];
                }

                $explodedAction = explode('::', $route['action']);
                $controller = $this->container->get($explodedAction[0]);

                if (isset($route['action']) && !empty($route['action'])) {
                    $this->doAction($controller, $explodedAction[1], "Undefined method", $params);
                } else {
                    throw new \Exception("Required parameter \"action\" is not set for this rule!");
                }

                break;
            }
        }
    }

    function doAction($controller, $action, $message, $params = array())
    {
        if (method_exists($controller,$action)) {
            $result = call_user_func_array(array($controller,$action),$params);

            echo $result;
        } else {
            throw new \Exception($message);
        }
    }

    private function init()
    {
        $this->routes = require_once __DIR__ . "/../../config/routes.php";
    }
}