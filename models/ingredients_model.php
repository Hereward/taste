<?php

class Ingredients_model extends Base_model {

    public $vars, $url_params, $view, $layout, $keyword, $page, $data;

    public function __construct() {
       // $this->vars = $vars;
      
    }


    public function load() {
       $output = array();
       $this->data = $this->parse_csv($_POST['ingredients']);
       return $this->data;
    }
    
    public function parse_csv($str) {
        $array = array();
        $lines = explode(PHP_EOL, trim($str));
        foreach ($lines as $line) {
            $array[] = str_getcsv($line);  
        }
        return $array; 
    }
    
    public function expired($item) {
        //$date = strtotime(trim($item[3]));
        // trim($item[3]
        $date_obj = DateTime::createFromFormat('j/n/Y', trim($item[3]));
        //$date_obj = DateTime::createFromFormat('j-M-Y', '15-Feb-2009');
        $date = $date_obj->getTimestamp();
        $now = strtotime("now");
        //echo "<div>expired: {$item[0]} | {$item[3]} | $date | $now </div>";
        if ($date <= $now) {
            return true;
        } else {
            return false;
        }
    }
    
    public function delete_expired() {
        $test = $this->data;
        $i = 0;
        foreach ($test as $item) {
           if ($this->expired($item)) {
               //echo "<div>{$item[0]} is expired!</div>";
               unset($this->data[$i]);
               $this->data = array_values($this->data);
           }
           $i++;
        }   
    }
}

