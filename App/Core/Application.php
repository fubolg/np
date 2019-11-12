<?php
namespace App\Core;

class Application
{
    private $config;

    public function run()
    {
        try {
            $this->init();

            $router = new Router();
            $router->route();
        } catch (\Exception $exception) {
            header('X-Error-Message: ' . $exception->getMessage(), true, 500);
            die;
        }
    }

    private function init()
    {
        $this->config = require_once __DIR__ . "/../../config/config.php";
    }
}