<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * User Model
 *
 * Handle User Data
 *
 * PHP version 5
 *
 * LICENSE: 
 *
 * @category   CategoryName
 * @author     Rajneel Ganjoo <rajneel@gmail.com>
 * @copyright  2010-2011 UC Berkeley 
 * @link       http://www.berkeley.edu
 */
Pfw_Loader::loadClass('Pfw_Model');
Pfw_Loader::loadClass('Pfw_Model_QueryObject');
#Pfw_Loader::loadClass('Prj_Core_Base');

class User extends Pfw_Model 
{
    protected static $_query_object;

    public function setup() {
        $this->setTable('users');
        $this->addBlockedField('password');
    }
    
    public function setupAssociations() 
    {
        /*
    	$this->hasMany('projects', array(
    		'table' => 'rel_project_user'
    	));
         
         */

    }    
    
	public static function validate_email_password($email, $pass) {
		if (empty($email) or empty($pass)) {
			return false; 
		}
		$sql = " SELECT * from users where email='$email' and password='$pass' limit 1";
		$response  = Pfw_Db::factory()->fetchOne($sql);
		if (!empty($response)) {
			return $response;
		}
    	return false;
    }
	
    
    public function validate($save_method) {
        Pfw_Loader::loadClass('Pfw_Validate');
        $pfv = new Pfw_Validate($this);
        
        if (Pfw_Model::SAVE_INSERT == $save_method) {
            $pfv->presence('first_name', 		"required!");
            $pfv->presence('last_name', 		"required!");
            $pfv->presence('email', 			"required!");
            $pfv->email('email', 				"Email is invalid!");
            $pfv->presence('password', 		"required!");
            if ($pfv->presence('email', 			"required!")){
                $email_user = User::Q()->getByEmail($this->email)->exec();
                if (!empty($email_user)) {
                    $this->addError('email', "email is taken");
                    $pfv->fail();
                }
            }
            
        }
        return $pfv->success();
    }
    
    public function isEmailValid($email, $message="")
    {
        // the email regular expression
        $pattern = '^([0-9a-zA-Z]([-\.\w]*[0-9a-zA-Z])*@([0-9a-zA-Z][-\w]*[0-9a-zA-Z]\.)+[a-zA-Z]{2,9})$';
        if (false !== eregi($pattern, $email)) {
        	return true;
        }
        else
        {
        	return false;
        }
    }
    
            
    public function emailExists($email)
    {
        $user = User::Q()->where(array('email = %s', $email))->exec();
        trigger_error(print_r($email,true));
		if(empty($user))
		{
			return false;
		}
        else
        {
        	return true;
        }
    }


    function encryptPassword($password)
    {
    	return md5($password);
    }
    
    
    // called before a record is inserted or updated
    // properties have been assigned to an instance 
    public function beforeSaveFilter(&$properties, $save_type) 
    {
        if(isset($properties['password']))
        {
        	$properties['password']     = $this->encryptPassword(trim($properties['password']));
        }

        foreach($properties as &$property)
        {
        	quote_smart(trim($property), false);
        }
    }
    
    public function login($email,$password)
    {
        $user  = null;
    	$user = User::Q()->getByAuth($email, $password)->limit(1)->exec();
    	error_log($email."[".$password."] attempted to login");
        return $user;
    }
    
    
    function deactivate()
    {
    	$sql = sprintf('UPDATE users SET is_active = 0 where id = %s', $this->id);
    	Pfw_Db::factory()->query($sql);
    }
    
    function activate()
    {
    	$sql = sprintf('UPDATE users SET is_active = 1 where id = %s', $this->id);
    	Pfw_Db::factory()->query($sql);
    }
    
    // called when a record is retrieved, before  
    // properties have been assigned to an instance 
    public function afterFetchFilter(&$properties) {}
    
    /**
     * Get an instance of a query object
     * 
     * @param Pfw_Db_Adapter $db instance of a db adapter
     * @return User_QueryObject
     */
    public static function Q($db = null)
    {
        $qo = __CLASS__."_QueryObject";
        return new $qo(__CLASS__, $db);
    }
}


class User_QueryObject extends Pfw_Model_QueryObject
{

    public function getByEmail($email)
    {
    	return User::Q()->where(array('this.email = %s', $email));
    }
    
    public function getByID($id)
    {
    	return User::Q()->where(array('this.id = %s', $id));
    }
    
    public function getByAuth($email,$password)
    {
        $user  = null;
    	$password = User::encryptPassword(trim($password));
		if (strpos($email, '@') !== false) {
			$user_sql =  User::Q()->getByEmail($email)->where(array('password = %s', $password));
            //$user =  User::Q()->where(array('this.email = %s', $email));
        }
		return $user_sql;
    }
}
