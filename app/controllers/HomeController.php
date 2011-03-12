<?php

Pfw_Loader::loadClass('Prj_Controller_Standard');

class HomeController extends Prj_Controller_Standard
{
    function setup() {
    }
    function indexAction()
    {
        $view = $this->getView();
        $view->assign('site_title','CalPalyn: Quaternary Paleoecology Lab');
        $view->display(array('layout' => 'layouts/main.tpl', 'body' => 'home/index.tpl'));
    }
}
