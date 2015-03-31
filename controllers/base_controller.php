<?php

class Base_controller  {

    public $url_params, $view, $layout;

    public function __construct() {

    }


    public function render_view($data='') {
        $path = __DIR__."/../views/layouts/$this->layout.view.php";
        ob_start();
        include $path;
        $content = ob_get_contents();
        ob_end_clean();
        echo $content;
    }


}

