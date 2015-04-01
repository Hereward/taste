<?php

require_once(__DIR__."../../../models/ingredients_model.php");

class ingredients_modelTest extends \PHPUnit_Framework_TestCase {
   
    public function testparse_csv_returns_array() {
        
        $originalString = 'bread,10,slices,3/4/2015';
        $container = array();
        $container[0] = array('bread','10','slices','3/4/2015');
        $expectedResult = $container;
        
        $ingredients_model = new Ingredients_model();

        $result = $ingredients_model->parse_csv($originalString);

        $this->assertEquals($expectedResult, $result);
    }
    
    public function testexpired_returns_true() {
        $originaldata = array('bread','10','slices','3/4/2013');;
        $expectedResult = true;
        $ingredients_model = new Ingredients_model();
        $result = $ingredients_model->expired($originaldata);
        $this->assertEquals($expectedResult, $result);
        
    }
    
    public function testexpired_returns_false() {
        $originaldata = array('bread','10','slices','3/4/2017');;
        $expectedResult = false;
        $ingredients_model = new Ingredients_model();
        $result = $ingredients_model->expired($originaldata);
        $this->assertEquals($expectedResult, $result);
        
    }

}