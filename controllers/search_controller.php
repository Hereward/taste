<?php

class Search_controller extends Base_controller {

    public $vars, $url_params, $view, $layout, $recipe_model, $ingredients_model;

    public function __construct($vars) {
        $this->vars = $vars;
        $this->recipe_model = new Recipe_model($vars);
        $this->ingredients_model = new Ingredients_model($vars);
    }

    public function index() {
        $this->layout = 'main';
        $this->view = 'search';
        $this->recipe_model->load();
        $this->ingredients_model->load();
        
        $this->ingredients_model->delete_expired();
        $this->recipe_model->set_viable_recipes($this->ingredients_model->data);
        $this->recipe_model->set_longevity($this->ingredients_model->data);
        
        $freshest = $this->recipe_model->find_freshest();
        
        //$title = $freshest['name'];
        
 
        //print_r($this->recipe_model->data);
        //die($title);
        
        //print_r($this->ingredients_model->data);
        $data = array('ingredients_messages'=>$this->ingredients_model->messages, 'recipe_messages'=>$this->recipe_model->messages, 'recommendation' => $freshest['name']);
        $this->render_view($data);
        //die();
    }

}

