<?php

class Recipe_model extends Base_model {

    public $url_params;
    public $view;
    public $layout;
    public $page;
    public $data;
    public $messages = array();

    public function __construct() {
        
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
            if (!$this->recipe_instock($recipe, $ingredients)) {

                $this->messages[] = "Removing &laquo;{$recipe['name']}&raquo; from inventory!";
                unset($this->data[$i]);
                $this->data = array_values($this->data);
            }
            $i++;
        }
    }

    public function recipe_instock($recipe, $ingredients) {
        $recipe_ingredients = $recipe['ingredients'];
        foreach ($recipe_ingredients as $ingredient) {
            if (!$this->ingredient_instock($ingredient, $ingredients)) {
                return false;
            }
        }
        return true;
    }

    public function ingredient_instock($ingredient, $ingredients) {
        $name = $ingredient['item'];

        foreach ($ingredients as $pantry_ingredient) {
            if ($pantry_ingredient[0] == $name && $pantry_ingredient[2] == $ingredient['unit'] && $pantry_ingredient[1] >= $ingredient['amount']) {
                return true;
            }
        }
        $this->messages[] = "$name - insufficient stock!";
        return false;
    }

    public function set_longevity($ingredients) {
        $recipes = $this->data;
        $i = 0;
        foreach ($recipes as $recipe) {
            $this->data[$i]['mean_age'] = $this->get_mean_longevity($recipe, $ingredients);
            $i++;
        }
    }

    public function get_mean_longevity($recipe, $ingredients) {
        $recipe_ingredients = $recipe['ingredients'];
        $days = array();
        foreach ($recipe_ingredients as $ingredient) {
            $name = $ingredient['item'];
            $days_left = $this->get_longevity($ingredient, $ingredients);
            //echo "$name | $days_left | \n";
            $days[] = array($name => $days_left);
        }

        $mean = $this->mean($days);
        return $mean;

        //print_r($days);
        //die();
    }

    public function get_longevity($ingredient, $ingredients) {
        $name = $ingredient['item'];

        foreach ($ingredients as $pantry_ingredient) {
            $pantry_name = $pantry_ingredient[0];
            $usebydate = $pantry_ingredient[3];

            if ($pantry_name == $name) {
                $date_obj = DateTime::createFromFormat('j/n/Y', trim($usebydate));
                $date = $date_obj->getTimestamp();
                $now = strtotime('now');
                $diff = $date - $now;
                $days = $diff / 60 / 60 / 24;
                return $days;
            }
        }
        //$this->messages[] = "$name - insufficient stock!";
        return false;
    }

    public function mean($days = array()) {
        $count = count($days);
        $tot = 0;
        foreach ($days as $item) {
            foreach ($item as $key => $value) {
                //echo "$value | ";
                $tot += $value;
            }
        }
        $mean = $tot / $count;
        return $mean;
    }

    public function find_freshest() {
        //arsort($age);
        $recipes = array();
        
        //print_r($this->data);
        //die();
        $i = 0;
        $small_array = array();
        
        foreach ($this->data as $item) {
            $key = "item_$i";
            $recipes[$key] = $item;
            $small_array[$key] = $item['mean_age'];
            $i++;
        }
        arsort($small_array);
        
        $key = current(array_keys($small_array));
        
        return $recipes[$key];
        
        
        //print_r($recipes);
        //print_r($small_array);
        
        //die();
    }

}
