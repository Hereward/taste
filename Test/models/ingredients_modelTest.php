<?php
require_once(__DIR__ . "../../../models/base_model.php");
require_once(__DIR__ . "../../../models/ingredients_model.php");

class ingredients_modelTest extends \PHPUnit_Framework_TestCase {
    /**
     * @dataProvider providerTestparse_csv_returns_array 
     * @param string $originalString csv string to be parsed
     * @param string $expectedResult resulting array 
     */

    public function testparse_csv_returns_array($originalString, $expectedResult) {
        $ingredients_model = new Ingredients_model();
        $result = $ingredients_model->parse_csv($originalString);
        $this->assertEquals($expectedResult, $result);
    }

    public function testexpired_returns_true() {
        $originaldata = array('bread', '10', 'slices', '3/4/2013');
        $expectedResult = true;
        $ingredients_model = new Ingredients_model();
        $result = $ingredients_model->expired($originaldata);
        $this->assertEquals($expectedResult, $result);
    }

    public function testexpired_returns_false() {
        $originaldata = array('bread', '10', 'slices', '3/4/2017');
        $expectedResult = false;
        $ingredients_model = new Ingredients_model();
        $result = $ingredients_model->expired($originaldata);
        $this->assertEquals($expectedResult, $result);
    }

    public function providerTestparse_csv_returns_array() {
        return array(
            array('##,1/0,%%,13/4/2015', array(array('##', '1/0', '%%', '13/4/2015'))),
            array('ONE,TWO,THREE,3/12/2015', array(array('ONE', 'TWO', 'THREE', '3/12/2015'))),
            array('1', array(array('1')))
        );
    }
    

}
