<?php

class App  {

    public $vars, $url_params, $view, $layout, $controller_name, $method, $config;

    public function __construct($config) {
        $this->config = $config;
        
    }

    public function init() {
        if ($this->config['debug']) {
            error_reporting(E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
            ini_set('display_errors', '1');
        } else {
            error_reporting(0);
        }

        $current_url = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        $this->vars['url_params'] = parse_url($current_url);
        $this->vars['url_segments'] =  explode('/',$this->vars['url_params']['path']);

        $this->route();

    }


    public function run() {
        require_once __DIR__.'/controllers/'.$this->controller_name.'_controller.php';
        $c_string = $this->controller_name.'_controller';
        //die($this->method);
        $controller = new $c_string($this->vars);
        $controller->{$this->method}();
    }


    public function route() {
        $this->method = 'index';
        if ($this->vars['url_segments'][1] == '') {
            $this->controller_name = 'index';
        } else {
            $this->controller_name = $this->vars['url_segments'][1];
        }
    }

}

