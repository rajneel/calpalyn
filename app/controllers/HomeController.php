<?php
ini_set('post_max_size',"11M");
ini_set('upload_max_filesize',"11M");
Pfw_Loader::loadClass('Prj_Controller_Standard');
Pfw_Loader::loadModel('Project');
class HomeController extends Prj_Controller_Standard
{
    public function __construct()
    {
        parent::__construct();
        // do any view initialization in here
        $view = $this->getView();
        $view->addCssLink('custom-theme/jquery-ui-1.8.10.custom.css');
        $view->addCssLink('fileuploader.css');
        $view->addJsLink('jquery-1.4.4.min.js');
        $view->addJsLink('jquery.dataTables.min.js');
        $view->addJsLink('highcharts.js');
        $view->addJsLink('exporting.js');
        //$view->addJsLink('jquery.jqUploader.js');
        //$view->addJsLink('jquery.flash.js');

        $view->addJsLink('fileuploader.js');
		#$view->addJsLink('jquery.simplemodal-1.3.4.min.js');
        $view->addJsLink('custom-theme/jquery-ui-1.8.10.custom.min.js');
        #$view->addJsLink('custom-theme/jquery-ui-form.custom.min.js');
    }

    function indexAction()
    {
        $view = $this->getView();
        $view->assign('home',true);
        $view->assign('site_title','CalPalyn: Quaternary Paleoecology Lab');
        // call project model
        $rows = Project::Q()->exec();
        //Not the most efficient but since there are handful of users
        $users = User::Q()->exec();
        foreach ($users as $user) {
            $u[$user->id] = array('email'=>$user->email,'first_name'=>$user->first_name);
        }
        error_log(print_r($rows,true));
        foreach ($rows as $row) {
            $d[] = array('id'=>$row->id,
                         'name'=>$row->name,
                         'user_info'=>"<a class='tip' name='#'>".$u[$row->created_by]['first_name']."<span>".$u[$row->created_by]['email']."</span></a>",
                         'desc'=>$row->description);
            $p[$row->id] = array('name'=>$row->name,'description'=>$row->description);
            error_log(print_r($d,true));
        }
        $view->assign('projects',$d);
        $view->assign('projects_info',$p);
        // Get list of taxons
        Pfw_Loader::loadModel('Taxon');
        $txs = Taxon::Q()->exec();
        //objp($txs);
        foreach ($txs as $t) {
            $taxons[$t->type]  = $t->name;
        }
        //objp($taxons);
        
        error_log("Taxons are ".print_r($taxons,true));
        $view->assign('taxons',$taxons);
        if (isset($_REQUEST['pid']) and !empty($_REQUEST['pid'])) {
            Pfw_Loader::loadModel('ProjectData');
            $key_data = ProjectData::Q()->getKeyValuesForProject($_REQUEST['pid']);
            $chart_data = $key_data['chart_data'];
            
            foreach ($chart_data as $cdk=>$cdv) {
               $depth_values = array_keys($cdv);
               $taxon_values = array_values($cdv);
               $chart_values[$cdk]=array('depth_min'=>min($depth_values),'depth_max'=>max($depth_values),
                                         'taxon_min'=>min($taxon_values),'taxon_max'=>max($taxon_values),
                                         'depths'=>self::_extendedEncode($depth_values, max($depth_values)),
                                         'taxon_values'=>self::_extendedEncode($taxon_values, max($taxon_values)));
            }
            #objp($chart_values);
            $view->assign('chart_data',$chart_values);
            $view->assign('field_names',$key_data['field_names']);
            $view->assign('project_data',$key_data['data']);
            $view->assign('project_id',$_REQUEST['pid']);
            $view->assign('depths',$key_data['depths']);   
            $view->assign('debug',print_r($view->get_template_vars(),true));
        }
        $view->display(array('layout' => 'layouts/main.tpl', 'body' => 'home/index.tpl'));
    }

    private static function _extendedEncode($arrVals,$maxVal) {

       // Same as simple encoding, but for extended encoding.
        $EXTENDED_MAP = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789-.';
        $EXTENDED_LIST = str_split($EXTENDED_MAP);
        $EXTENDED_MAP_LENGTH = sizeof($EXTENDED_LIST);
        //objp($arrVals);
        //$chartData = 'e:';
        $maxVal = $maxVal + 5; // set the max larger than max of list
        $len = sizeof($arrVals);
        for($i = 0;$i < $len;$i++) {
            $scaledVal = floor($EXTENDED_MAP_LENGTH * $EXTENDED_MAP_LENGTH * $arrVals[$i]/ $maxVal);
            //objp($scaledVal);
            if($scaledVal > (($EXTENDED_MAP_LENGTH * $EXTENDED_MAP_LENGTH) - 1)) {
                $chartData .= "..";
            } else if ($scaledVal < 0) {
                $chartData .= '__';
            } else {
                // Calculate first and second digits and add them to the output.
                $quotient = floor($scaledVal / $EXTENDED_MAP_LENGTH);
                $remainder = $scaledVal - $EXTENDED_MAP_LENGTH * $quotient;
                $chartData .= $EXTENDED_LIST[$quotient].$EXTENDED_LIST[$remainder];
            }
        }
        return $chartData;
  }


   
}
