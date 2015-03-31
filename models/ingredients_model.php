<?php

class Ingredients_model extends Base_model {

    public $vars, $url_params, $view, $layout, $keyword, $page, $data;

    public function __construct() {
       // $this->vars = $vars;
      
    }


    public function load() {
       $output = array();
       //var_dump($_POST['recipes']);
       //$recipes = json_decode($_POST['recipes'], true);
       //var_dump($recipes);
       //die($_POST['ingredients']);
       $this->data = $this->parse_csv($_POST['ingredients']);
       //$output['recipes'] = $recipes;
       //$output['ingredients'] = $ingredients;
       
       //var_dump($recipes);
       //var_dump($ingredients);
        //print_r($output);
       //die();
      
       return $this->data;
    }
    
    public function parse_csv($str) {
        $array = array();
        $lines = explode(PHP_EOL, $str);
        foreach ($lines as $line) {
            //echo $line . "\n";
            $array[] = str_getcsv($line);  
        }
        //var_dump($array);
        //die();
        return $array; 
    }


}

