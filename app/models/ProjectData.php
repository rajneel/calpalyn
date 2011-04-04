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

class ProjectData extends Pfw_Model
{
    protected static $_query_object;
    /*
    public function __construct($pid=0) {
        if (!empty($pid)) {
            $this->project_id = $pid;
        }
        parent::__construct();
    }

     */
    
    public function setup() {
        $this->setTable('project_data');
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


class ProjectData_QueryObject extends Pfw_Model_QueryObject
{

    public function getKeyValuesForProject($pid) {
        if (empty($pid)) {
            return false;
        }
        $response  = $this->where("project_id=".$pid)->exec();
        foreach ($response as $r) {
            $data[$r->depth][$r->taxon_type]=$r->taxon_value;
            $f[] = $r->taxon_type;
            $d[] = $r->depth;
        }
        
       
        $field_names = array_unique($f);
        $depths = array_unique($d);
        error_log("Got all depths for project[$pid] as ".print_r($depths,true));
        return array('depths'=>array_values($depths),'field_names'=>array_values($field_names),'data'=>$data);
    }



} 
