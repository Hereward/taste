<?php
require_once(__DIR__ . "../../../models/base_model.php");
require_once(__DIR__ . "../../../models/recipe_model.php");

class recipe_modelTest extends \PHPUnit_Framework_TestCase {
    
    /**
     * @dataProvider providerTestmean 
     * @param string $originalArray array of numbers
     * @param string $expectedResult calculated mean
     */
    

    public function testmean($originalArray,$expectedResult) {
        $recipe_model = new Recipe_model();
        $result = $recipe_model->mean($originalArray);
        $this->assertEquals($expectedResult, $result); 
    }
    
    
    public function providerTestmean() {
        return array(
            array(array(array('item_0'=>2),array('item_1'=>4),array('item_2'=>6)),4),
            array(array(array('item_0'=>30),array('item_1'=>35),array('item_2'=>40)),35),
            array(array(array('item_0'=>67),array('item_1'=>24),array('item_2'=>83)),58)
        );
    }
    
    
    public function testget_longevityReturnsAvalue() {
        
        $ingredients_model = $this->getMockBuilder('Ingredients_model')
            ->setConstructorArgs(array())
            ->getMock();
        $ingredients_model->data = array(
            array('bread', '10', 'slices', '4/4/2017'),
            array('cheese', '250', 'slices', '25/12/2015'),
            array('butter', '250', 'grams', '25/12/2015'),
            array('peanut butter', 'grams', 'slices', '2/12/2015'),
            array('mixed salad', '500', 'grams', '26/12/2015')
            );
        
        $recipe_model = new Recipe_model();
        $ingredient = array(
            'item'=>'bread',
            'amount'=>'2',
            'unit'=>'slices'
        );
        
        $result = $recipe_model->get_longevity($ingredient, $ingredients_model->data);
        
        $expectedResult = ($result>0);

        $this->assertEquals($expectedResult, $result); 
    }
    
   
     

}