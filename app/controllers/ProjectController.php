<?php
ini_set('post_max_size',"11M");
ini_set('upload_max_filesize',"11M");

Pfw_Loader::loadClass('Prj_Controller_Standard');
Pfw_Loader::loadClass('Prj_Components_FileUploaderComponent');
Pfw_Loader::loadModel('Project');
class ProjectController extends Prj_Controller_Standard
{
    public function __construct()
    {
        parent::__construct();
        // do any view initialization in here
        error_log(">>>IN PROJECT CONTROLLER[".__CLASS__."]");
        $view = $this->getView();
        $view->addCssLink('custom-theme/jquery-ui-1.8.10.custom.css');
        $view->addJsLink('jquery-1.4.4.min.js');
        $view->addJsLink('jquery.dataTables.min.js');
		#$view->addJsLink('jquery.simplemodal-1.3.4.min.js');
        //$view->addCssLink('jquery.fileupload-ui.css');
        //$view->addJsLink('jquery.fileupload.js');
        //$view->addJsLink('jquery.fileupload-ui.js');
        $view->addJsLink('jquery.jqUploader.js');
        $view->addJsLink('jquery.flash.js');
        $view->addJsLink('custom-theme/jquery-ui-1.8.10.custom.min.js');
        #$view->addJsLink('custom-theme/jquery-ui-form.custom.min.js');
    }

    function indexAction()
    {
        $view = $this->getView();
        $view->assign('site_title','CalPalyn: Quaternary Paleoecology Lab Project Listing Page');
        $view->display(array('layout' => 'layouts/main.tpl', 'body' => 'project/index.tpl'));
    }

    function partMarkupAction() {
        echo self::_getUploadMarkup(1);
    }

    function createAction() {
        $project = new Project;
        $project->name= $_REQUEST['project_name'];
        $project->description = $_REQUEST['project_desc'];
        $project->dt_created = mysql_time();
        $project->created_by =  Pfw_Session::get('login_id');
        try {
            $project->save();
        }
        catch (Exception $e) {
            error_log("Caught exception with [".$e->getMessage()."]");
        }
        $this->redirect("/home");
        return;
    }

    function jsonListProjectsAction() {
        $sEcho  = $_REQUEST['sEcho'];
        $columns = array('ProjectId','ProjectName', 'ProjectOwner','ProjectDesc','ProjectDataStatus');
        // create a dummy array for now
        header("Content-Type: application/json");
        // mock data
        //$d = array(array(1,2,3,4),array('a','b','c','d'),array('x','y','z','zz'));
        //$s = sizeof($d);
        // real data
        $rows = Project::Q()->exec();
        //Not the most efficient but since there are handful of users
        $users = User::Q()->exec();
        foreach ($users as $user) {
            $u[$user->id] = array('email'=>$user->email,'first_name'=>$user->first_name);
        }
        error_log(print_r($rows,true));
        foreach ($rows as $row) {
            $d[] = array($row->id,
                         $row->name,
                         "<a class='tip' name='#'>".$u[$row->created_by]['first_name']."<span>".$u[$row->created_by]['email']."</span></a>",
                         $row->description,
                         ($row->has_data)?"<a href='#?pid=".$row->id."'>View</a>":self::_getUploadMarkup($row->id));
            error_log(print_r($d,true));
        }
        $s = count($d);
        //error_log(print_r($rows,true));
        
        $data = array('aaData'=>$d,'iTotalRecords'=>$s,
                      'iTotalDisplayRecords'=>$s,
                      'sEcho'=>$sEcho,
                      'sColumns'=>$columns);
        $response = json_encode($data);
        echo $response;
        return;
    }

    function uploadAction() {
        $project_id = $_REQUEST['pid'];
        $uploader = new Prj_Components_FileUploaderComponent( array('txt','xls','xlsx','csv'),1048576*2);
        $response =  $uploader->handleUploadJson('/tmp/');
        $a_response = (array)json_decode(($response));
        if (isset($a_response['filename'])) {
            // read file into memory
            self::saveFileToProject($a_response['filename'],$project_id);
        }
        error_log("Uploader returned[".print_r($a_response, true)."]");
        echo $response;
        return true;
    }

    private static function saveFileToProject($filename,$pid) {
        $data = array();
        $row  = 1;
        if (($fhandle = fopen($filename, "r")) !== FALSE) {
            while (($d = fgetcsv($fhandle, 10000, ",")) !== FALSE) {
               // process row specially
                if ($row == 1) {
                    $field_names = $d;
                }
                else {
                    $data[] = $d;
                }
               $row++;
            }
            // call validation routines
            $project  = new Project($pid);
            $project->saveProjectData($data,array('field_names'=>$field_names,'pid'=>$pid));
            fclose($fhandle);
            // unlink file. No need to clog up space
        }
        else {
                error_log("Could not open file[".$a_response['filename']."]");
        }
    }
    

    private static function _getUploadMarkup($pid) {
        $markup  = <<<EOD
<div class='upload-ui'>
<div id='switch'>
    <div class='b_upload'>
        <button id='u_button' class='upload-ui' name='u_button'>Upload</button>
    </div>
    <div class='f_upload'>
        <form enctype='multipart/form-data' action='/project/upload' method='POST'>
            <span id='upload'>
                <input name='fileToUpload' type='file' />
                <input type='hidden' name='pid' value=$pid/>
            </span>
            <input class='f_upload upload-ui' type='submit' value='Upload' />
        </form>
    </div>
    </div>
</div>
EOD;
        return $markup;
    }


}
