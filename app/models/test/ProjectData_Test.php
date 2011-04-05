<?php 

Pfw_Loader::loadClass('Pfw_UnitTest_PHPUnit_TestCase');
Pfw_Loader::loadModel('ProjectData');

class ProjectData_Test extends Pfw_UnitTest_PHPUnit_TestCase
{
    protected function setup(){
        // runs before every test
    }

    protected function tearDown(){
        // runs after every test
    }
 	
    public function xtestGetKeyData() {
        $data = ProjectData::Q()->getKeyValuesForProject(1);
        print_r($data);
        $this->assertNotNull($data);
    }

    public function testDepths() {
        $project_data = new ProjectData;
        $depths = $project_data->getDepths(1);
        $this->assertNotNull($depths);
        print_r($depths);
    }
}
