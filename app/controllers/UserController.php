<?php
/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * UserController
 *
 * This controller supports the user registration flow.
 *
 * PHP version 5
 *
 * LICENSE: 
 *
 * @category   CategoryName
 * @author     Rajneel Ganjoo<rajneel@gmail.com>
 * @copyright  2011-2012 UC Berkeley 
 * @version    Git: $Id$
 * @link       http://www.berkeley.edu
 */

/**
 *  Load classes
 */
Pfw_Loader::loadClass('Prj_Controller_Standard');
Pfw_Loader::loadModel('User');

class UserController extends Prj_Controller_Standard 
{
    public $access_allowed = true;

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

    }

    function indexAction() {
        $view = $this->getView();
        $view->assign('site_title','CalPalyn: Login Page');
        $view->display(array('layout' => 'layouts/main.tpl', 'body' => 'user/login.tpl'));
    }
    
    /*
     * Login
     */
    function loginAction($params=array())
    {
    	$view = $this->getView();
    	$user = new User();
		if ($this->isPost()) 
		{
			$user->formSetProperties($this->getParam('user'));
            error_log("user email is ".$user->email." and password is ".$user->password);
	    	$email = $user->email;
	    	$password = $user->password;
            $user = $user->login($email,$password);
            #objp($user);
	    	if (isset($user->id)) 
	    	{
	    		# user exists
	    		Pfw_Session::set('is_logged_in',true);
	    		Pfw_Session::set('login_id',$user->id);                   
		    	if(isset($_REQUEST['redir']) and !empty($_REQUEST['redir']))
		    	{
                    $this->redirect($_REQUEST['redir']);
		    	}
		    	else
		    	{
                    error_log("Redirect is not set up: redirecting to /");
		    	}
	    	}
	    	else
	    	{
                error_log("User not available with this loginname and/or password");
				$view->assign('login_error', true);
				$this->redirect('/user/login');
	    	}
		} 
		
		// url to redirect to after successful login
		$fromUrl = $_REQUEST['redir'];
		  	
    	$view->assign('redir', $fromUrl);
    	$view->assign('user', $user);
        $view->assign('site_title','CalPalyn: Login Page');
        $view->display(array('layout' => 'layouts/main.tpl', 'body' => 'user/login.tpl'));

    }
    
    
    /**
     * Logout
     */
    function logoutAction() {

    	Pfw_Session::set('is_logged_in',false);
    	Pfw_Session::clear('login_id');

    	$this->redirect('/user/login');
    }
}
