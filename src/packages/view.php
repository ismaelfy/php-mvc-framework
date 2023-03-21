<?php

namespace App\Packages;

class View
{
    protected $view;
    protected $data = [];
    protected static $globalData = [];
    protected static $layout;

    public function __construct($view)
    {
        $this->view = $view;
    }

    public function with($key, $value)
    {
        $this->data[$key] = $value;
        return $this;
    }

    public static function share($key, $value)
    {
        self::$globalData[$key] = $value;
    }

    public static function layout($layout)
    {
        self::$layout = $layout;
    }

    public function render()
    {
        extract($this->data);
        extract(self::$globalData);
        ob_start();
        include $this->viewPath();
        $content = ob_get_clean();
        if (self::$layout) {
            include self::$layout;
        } else {
            echo $content;
        }
    }

    protected function viewPath()
    {
        return 'app/views/' . $this->view . '.php';
    }
}
