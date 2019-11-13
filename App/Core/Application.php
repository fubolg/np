<?php
namespace App\Core;

class Application
{
    private $router;

    /**
     * Application constructor.
     * @param Router $router
     */
    public function __construct($router)
    {
        $this->router = $router;
    }

    public function run()
    {
        try {
            $this->router->route();
        } catch (\Exception $exception) {
            var_dump($exception);
            header('X-Error-Message: ' . $exception->getMessage(), true, 500);
            die;
        }
    }
}