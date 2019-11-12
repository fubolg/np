<?php


class Autoloader
{
    /**
     * Autoloader constructor.
     */
    public function __construct()
    {
        spl_autoload_register(array($this, 'autoload'));
    }

    /**
     * @param $className
     *
     * @throws Exception
     */
    private function autoload($className)
    {
        $class = str_replace('\\', DIRECTORY_SEPARATOR,$className);
        $filename = __DIR__ . "/../../$class.php";

        if (file_exists($filename)) {
            require_once $filename;
        } else {
            throw new \Exception('Class file ' . $className . ' Not Found');
        }
    }
}