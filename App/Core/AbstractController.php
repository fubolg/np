<?php
namespace App\Core;


abstract class AbstractController
{
    /**
     * @var View
     */
    protected $view;

    protected $layout = 'main.php';

    protected $errors = [];

    public function __construct()
    {
        $this->view = new View();
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

    protected function getRequestBody() {
        return file_get_contents('php://input');
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
        $resultMessage = json_last_error();
        if ($resultMessage !== JSON_ERROR_NONE) {
            if (is_bool($resultMessage)) {
                $resultMessage = 'Json Parse Error';
            }

            throw new \JsonException($resultMessage);
        }
    }

    protected function getErrors()
    {
        return $this->errors;
    }

    protected function addError($error)
    {
        $this->errors[] = $error;
    }

    protected function clearErrors()
    {
        $this->errors = [];
    }
}