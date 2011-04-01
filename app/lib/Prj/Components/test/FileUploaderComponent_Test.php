<?php
Pfw_Loader::loadClass('Pfw_UnitTest_PHPUnit_TestCase');
require_once ('../FileUploaderComponent.php');


class FileUploaderComponent_Test extends Pfw_UnitTest_PHPUnit_TestCase {
    
    public function setup() {
    } 

    public function tearDown() {
    } 

    public function testSomething() {
        $com = new Prj_Components_FileUploaderComponent(array('xls','csv'));
    }


}
