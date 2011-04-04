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
    /*
    public function __construct($pid=0) {
        if (!empty($pid)) {
            $this->project_id = $pid;
        }
        parent::__construct();
    }

     */
    
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

    public function saveProjectData($data,$options) {
         // Create taxon map one time
        Pfw_Loader::loadModel('Taxon');
        $field_names  = $options['field_names'];
        $pid = $options['pid'];
        $num_cols  = count($field_names);
        $taxons = Taxon::Q()->exec();
        $taxon  = array();
        // strtolower
        $fields = array_filter($field_names, "strtolower");
        $depth_index = array_search('depth',$fields);
        error_log("fields columns are ".print_r($fields,true));
        foreach ($taxons as $t) {
            $taxon[$t->name] = $t->type;
        }
        error_log("taxons are ".print_r($taxon,true));
        // foreach row in data array process individual columns
        foreach ($data as $d) {
            $sql = null;
            $depth = $d[$depth_index];
            for ($i=0;$i<$num_cols;$i++) {
                if ($i == $depth_index) {
                    continue;

                }
                //error_log(print_r($d,true));
                $tname = strtolower($fields[$i]);
                $null_val = "'NULL'";
                $taxon_type = empty($taxon[$tname])?$null_val:$taxon[$tname];
                $taxon_value  = empty($d[$i])?$null_val:$d[$i];
                error_log("TAXON VALUE IS $taxon_value");
                $sql = "INSERT  INTO project_data (project_id,depth,taxon_type, taxon_value) VALUES($pid,$depth,$taxon_type,$taxon_value);";
                error_log($sql);
                Pfw_Db::factory()->query($sql);
                
            }
            // now fire the insert sql
            
            
        }



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
