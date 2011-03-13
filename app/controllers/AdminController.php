<?php

Pfw_Loader::loadClass('Prj_Controller_Standard');

class AdminController extends Prj_Controller_Standard
{
    public $layout = 'layouts/main.tpl';
    
    public function __construct()
    {
        parent::__construct();
        // do any view initialization in here
        $view = $this->getView();
        $view->addCssLink('custom-theme/jquery-ui-1.8.10.custom.css');
        $view->addJsLink('jquery-1.4.4.min.js');
		#$view->addJsLink('jquery.simplemodal-1.3.4.min.js');
        $view->addJsLink('custom-theme/jquery-ui-1.8.10.custom.min.js');
        #$view->addJsLink('custom-theme/jquery-ui-form.custom.min.js');
        if (isset($_REQUEST['nonav']) and $_REQUEST['nonav']) {
            $this->layout = 'layouts/bare.tpl';
        }
    }

    function indexAction()
    {
        $view = $this->getView();
        $view->assign('site_title','CalPalyn: Quaternary Paleoecology Lab Admin Page');
        $view->display(array('layout' => $this->layout, 'body' => 'admin/index.tpl'));
    }
}
