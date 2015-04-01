<?php

/*
   @package		Recipe Builder
 * @author		Hereward Fenton
 * @copyright	Copyright (c) 2015, Eye of the Tiger Pty Ltd.
 */

class Index_controller extends Base_controller {

    public $vars, $url_params, $view, $layout;

    public function __construct($vars) {
        $this->vars = $vars;
    }
    
    /* Index Controller 
     * This controller loads the home page.
    */

    public function index() {
        $this->layout = 'main';
        $this->view = 'index';
        $data = array();
        $this->render_view($data);
    }


}

