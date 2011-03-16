<?php

Pfw_Loader::loadClass('Prj_Controller_Standard');
Pfw_Loader::loadModel('Project');
class ProjectController extends Prj_Controller_Standard
{
    public function __construct()
    {
        parent::__construct();
        // do any view initialization in here
        $view = $this->getView();
        $view->addCssLink('custom-theme/jquery-ui-1.8.10.custom.css');
        $view->addJsLink('jquery-1.4.4.min.js');
        $view->addJsLink('jquery.dataTables.min.js');
		#$view->addJsLink('jquery.simplemodal-1.3.4.min.js');
        $view->addJsLink('custom-theme/jquery-ui-1.8.10.custom.min.js');
        #$view->addJsLink('custom-theme/jquery-ui-form.custom.min.js');
    }

    function indexAction()
    {
        $view = $this->getView();
        $view->assign('site_title','CalPalyn: Quaternary Paleoecology Lab Project Listing Page');
        $view->display(array('layout' => 'layouts/main.tpl', 'body' => 'project/index.tpl'));
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
            $d[] = array($row->id,$row->name, "<a class='tip' name='#'>".$u[$row->created_by]['first_name']."<span>".$u[$row->created_by]['email']."</span></a>",$row->description, ($row->has_data)?"<a href='#?pid=".$row->id."'>View</a>":"<a href='#?pid=".$row->id."'>Upload</a>");
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

    function jsonFileUpload() {
        $project_id = $_REQUEST['pid'];
        
    }


}
