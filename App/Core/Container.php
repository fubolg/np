<?php

namespace App\Core;


class Container
{
    private $tree = [];

    public function __construct()
    {
        $this->buildTree();
    }

    private function buildTree()
    {
        $config = require_once __DIR__ . "/../../config/config.php";

        $services = $config['services'];
        unset($config['services']);

        foreach ($config as $key => $param) {
            $this->set($key, $param);
        }

        foreach ($services as $serviceName => $service) {
            $this->set($serviceName, function () use ($serviceName, $service){
                $r = new \ReflectionClass($serviceName);
                $arguments = [];

                foreach ($service['arguments'] as $argument) {
                    $arguments[] = $this->get($argument);
                }

                if (empty($argument)) {
                    $argument = null;
                }

                return $r->newInstanceArgs($arguments);
            });
        }

        $this->set('connection', new \PDO($this->get('db')['dsn'], $this->get('db')['username'], $this->get('db')['passwd']));
        $this->set(__CLASS__, $this);
    }

    public function set($key, $param)
    {
        $this->tree[$key] = $param;
    }

    public function get($key)
    {
        return $this->tree[$key] instanceof \Closure ? $this->tree[$key]() : $this->tree[$key];
    }
}