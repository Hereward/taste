<?php

/*
   @package		Recipe Builder
 * @author		Hereward Fenton
 * @copyright	Copyright (c) 2015, Eye of the Tiger Pty Ltd.
 */

  /* Recipe Model 
     * This model represents the recipe data which is loaded from the JSON data.
  */

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
        $this->data = json_decode($_POST['recipes'], true);
        return $this->data;
    }
    
    // Functions below are concerned with matching ingredients with recipes, to return a list of viable recipes
     
    public function set_viable_recipes($ingredients) {
        $recipes = $this->data;
        $i = 0;
        foreach ($recipes as $recipe) {
            if (!$this->recipe_instock($recipe, $ingredients)) {
                $this->messages[] = "Removing &laquo;{$recipe['name']}&raquo; from inventory!";
                unset($this->data[$i]);
            }
            $i++;
        }
        $this->data = array_values($this->data);
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
    
    
    // Functions below are concerned determining the priority of meals based on the freshness of ingredients

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
            $days[] = array($name => $days_left);
        }

        $mean = $this->mean($days);
        return $mean;

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
        return false;
    }

    public function mean($days = array()) {
        $count = count($days);
        $tot = 0;
        foreach ($days as $item) {
            foreach ($item as $key => $value) {
                $tot += $value;
            }
        }
        $mean = $tot / $count;
        return $mean;
    }

    public function find_freshest() {
        $recipes = array();
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
    }

}
