<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Project Model
 *
 * Handle Project Data
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
Pfw_Loader::loadClass('Prj_Core_Base');

class Project extends Pfw_Model 
{
    protected static $_query_object;

    public function setup() {
        $this->setTable('projects');
    }
    
    public function setupAssociations() 
    {
        // set up any associations here
    }    
    
    public function validate($save_method) {
        Pfw_Loader::loadClass('Pfw_Validate');
        $pfv = new Pfw_Validate($this);
        
        if (Pfw_Model::SAVE_INSERT == $save_method) {
            $pfv->presence('name', 		"required!");
            $pfv->presence('description', 		"required!");
        }
        return $pfv->success();
    }
    
    
    
    // called when a record is retrieved, before  
    // properties have been assigned to an instance 
    public function afterFetchFilter(&$properties) {}
    
    /**
     * Get an instance of a query object
     * 
     * @param Pfw_Db_Adapter $db instance of a db adapter
     * @return Project_QueryObject
     */
    public static function Q($db = null)
    {
        $qo = __CLASS__."_QueryObject";
        return new $qo(__CLASS__, $db);
    }
}


class Project_QueryObject extends Pfw_Model_QueryObject
{
}
