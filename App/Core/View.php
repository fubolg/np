<?php
namespace App\Core;

class View
{
    const VIEW_PATH = '../templates';

    /**
     * @param $template
     * @param null $data
     *
     * @return false|string
     *
     * @throws \Exception
     */
    public static function render($template, $data = null)
    {
        if (!in_array(gettype($data), ['NULL', 'array'])) {
            throw new \Exception(sprintf('Parameter %s for method %s Should be %s, %s given!', '$data', __METHOD__, 'array or null', gettype($data)));
        }

        if (is_array($data)) {
            extract($data);
        }

        $filename = self::VIEW_PATH . '/' . $template;

        if (!file_exists($filename)) {
            throw new \Exception(sprintf('Template file was not found %s (:!', $filename));
        }

        ob_start();
        ob_implicit_flush(false);
        include $filename;

        return ob_get_clean();
    }
}