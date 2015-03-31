<?php

class Index_controller extends Base_controller {

    public $vars, $url_params, $view, $layout;

    public function __construct($vars) {
        $this->vars = $vars;
    }

    public function index() {
        $this->layout = 'main';
        $this->view = 'index';
        $data = array();
        $data['fruit'] = 'banana';
        $this->render_view($data);
    }


}

