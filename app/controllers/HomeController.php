<?php

Pfw_Loader::loadClass('Prj_Controller_Standard');

class HomeController extends Prj_Controller_Standard
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
        $view->assign('home',true);
        $view->assign('site_title','CalPalyn: Quaternary Paleoecology Lab');
        $view->display(array('layout' => 'layouts/main.tpl', 'body' => 'home/index.tpl'));
    }

   
}
