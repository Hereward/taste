<?php

/*
  @package		Recipe Builder
 * @author		Hereward Fenton
 * @copyright	Copyright (c) 2015, Eye of the Tiger Pty Ltd.
 */

class Search_controller extends Base_controller {

    public $vars, $url_params, $view, $layout, $recipe_model, $ingredients_model;

    public function __construct($vars) {
        $this->vars = $vars;
        $this->recipe_model = new Recipe_model();
        $this->ingredients_model = new Ingredients_model();
    }

    /* Search Controller 
     * This is the main app controller which loads the models outpus the search results.
     */

    public function index() {
        $this->layout = 'main';
        $this->view = 'search';
        $this->recipe_model->load();
        $this->ingredients_model->load();
        
        $this->ingredients_model->delete_expired();
        $this->recipe_model->set_viable_recipes($this->ingredients_model->data);
        

        if (count($this->recipe_model->data) > 0) {
            $this->recipe_model->set_longevity($this->ingredients_model->data);
            $freshest = $this->recipe_model->find_freshest();
            $data = array('ingredients_messages' => $this->ingredients_model->messages, 'recipe_messages' => $this->recipe_model->messages, 'recommendation' => $freshest['name']);
        } else {
  
            $data = array('ingredients_messages' => $this->ingredients_model->messages, 'recipe_messages' => $this->recipe_model->messages, 'recommendation' =>  "Nothing: everything is out of stock!");
        }
        $this->render_view($data);
    }

}
