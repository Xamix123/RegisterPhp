<?php

namespace testTask1\app\view;

class View
{
    protected $data;

    private $template;

    public function __construct($template)
    {
        $this->template = $template;
    }

    /**
     * @return false|string
     */
    public function render()
    {
        ob_start();
        require "app/resources/views/" . $this->template . ".php";
        $str = ob_get_contents();
        ob_end_clean();
        return $str;
    }

    /**
     * @param $key
     * @param $val
     */
    public function assign($key, $val)
    {
        $this->data[$key] = $val;
    }
}
