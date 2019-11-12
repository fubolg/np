<?php
namespace App\Core;

use App\Model\Model;

abstract class AbstractController
{
    /**
     * @var View
     */
    protected $view;
    protected $model;
    protected $layout = 'main.php';

    public function __construct()
    {
        $this->view = new View();
        $this->model = new Model();
    }

    abstract function actionIndex();

    public function render($view, $params = [])
    {
        $content = $this->getView()->render($view, $params);
        return $this->renderContent($content);
    }

    public function renderContent($content)
    {
        return $this->getView()->render($this->layout, ['content' => $content]);
    }
    /**
     * @return View
     */
    public function getView()
    {
        return $this->view;
    }

    /**
     * @param string $layout
     */
    public function setLayout($layout)
    {
        $this->layout = $layout;
    }

    protected function isAjax() {
        return !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    protected function getRequestParams() {

        $method = $_SERVER['REQUEST_METHOD'];

        switch ($method) {
            case ('GET') :
                $params = $_GET;
                break;
            case  ('POST') :
                $params = $_POST;
                break;
            default:
                $params = [];
        }

        return $params;
    }

    protected function getClientIp()
    {
        $ip = null;

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    protected function parseJson($json, $assoc = false, $depth = 512, $options = 0)
    {
        $result = json_decode($json, $assoc, $depth, $options);
        $jsonStatusCode = json_last_error();
        if ($jsonStatusCode !== JSON_ERROR_NONE) {
            throw new \JsonException('Json Parse Error');
        }
    }
}