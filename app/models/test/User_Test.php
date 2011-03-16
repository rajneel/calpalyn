<?php 

Pfw_Loader::loadClass('Pfw_UnitTest_PHPUnit_TestCase');
Pfw_Loader::loadModel('User');

class User_Test extends Pfw_UnitTest_PHPUnit_TestCase
{
    protected function setup(){
        // runs before every test
    }

    protected function tearDown(){
        // runs after every test
    }
 	
	public function testLogin()
	{
        $u = new User();
       	$first_name 		= 'phpunit_'.uniqid();
        $u->first_name 		= $first_name;
        $u->last_name 		= "smith";
        $u->email 			= $first_name.'@example.com';
        $u->password 		= 'toast';
        $u->password_confirm = 'toast';
        $u_id = $u->save();
        
        # check username password validation

    	$u2 = User::Q()->getByAuth($u->email,$u->password)->limit(1)->exec();
        //objp($u2);
    	$this->assertEquals($u2->email, $u->email);
    	
		$updated_count = User::Q()->deleteAll(array('first_name = %s', $first_name));
		
		$this->assertEquals($updated_count, 1);
    	
	}
    public function testLogin2() {
        $u = new User;
        $u2 = $u->login('neel@ganjoo.com','calpalyn');
        #objp($u2);
        $this->assertEquals($u2->first_name,'admin');
    }

}
