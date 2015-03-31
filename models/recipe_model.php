<?php

class Recipe_model extends Base_model {

    public $vars, $url_params, $view, $layout, $keyword, $page, $data;

    public function __construct() {
       // $this->vars = $vars;
      
    }


    public function load() {
       $output = array();
       //var_dump($_POST['recipes']);
       $this->data = json_decode($_POST['recipes'], true);
       //var_dump($recipes);
       //die($_POST['ingredients']);
       //$ingredients = $this->parse_csv($_POST['ingredients']);
       //$output['recipes'] = $recipes;
       //$output['ingredients'] = $ingredients;
       
       //var_dump($recipes);
       //var_dump($ingredients);
        //print_r($output);
       //die();
      
       return $this->data;
    }
    
    public function set_viable_recipes($ingredients) {
       $recipes = $this->data;
       $i = 0;
        foreach ($recipes as $recipe) {
            if (!$this->recipe_instock($recipe,$ingredients)) {
               unset($this->data[$i]);
               $this->data = array_values($this->data);
            }
            $i++;
        }
    }
        
    public function recipe_instock($recipe,$ingredients) {
            $recipe_ingredients =  $recipe['ingredients'];
            foreach ($recipe_ingredients as $ingredient) {
                if (!$this->ingredient_instock($ingredient,$ingredients)) {
                    return false;
                }
            }
            return true;
    }
    
    public function ingredient_instock($ingredient,$ingredients) {
        $name = $ingredient['item'];
        
        foreach ($ingredients as $pantry_ingredient) {
            if ($pantry_ingredient[0] == $name && $pantry_ingredient[2] == $ingredient['unit'] && $pantry_ingredient[1] >= $ingredient['amount']) {
                return true;  
            }
        }
        //echo "<div>$name is out of stock!</div>";
        return false;
    }
        
    
    

}

