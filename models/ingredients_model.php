<?php

/*
   @package		Recipe Builder
 * @author		Hereward Fenton
 * @copyright	Copyright (c) 2015, Eye of the Tiger Pty Ltd.
 */

  /* Ingredients Model 
     * This model represents the ingredients data which is loaded from the CSV data.
  */

class Ingredients_model {

    public $view;
    public $layout;
    public $page;
    public $data;
    public $messages = array();

    public function __construct() {

      
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
    
    // Functions below identify and remove expired items from the ingredients inventory
    
    public function expired($item) {
        $date_obj = DateTime::createFromFormat('j/n/Y', trim($item[3]));
        $date = $date_obj->getTimestamp();
        $now = strtotime("now");
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
               $this->messages[] = "{$item[0]} is expired - removing from inventory!";
               unset($this->data[$i]);
           }
           $i++;
        }   
        $this->data = array_values($this->data);
    }
}

