<?php

/**
 * This is the controller class used in your project. Add in code here to extend it.
 */

Pfw_Loader::loadClass('Pfw_Controller_Standard');

class Prj_Controller_Standard extends Pfw_Controller_Standard
{
    public function __construct()
    {
        try {
            $this->checkAllowed();
        }
        catch (Exception $e) {
            error_log ("Check Allowed Function Failed with message [".$e->getMessage()."]");
        }
        self::setupView();
        return parent::__construct();
    }


    protected function checkAllowed() {
    	error_log("Action is [".Pfw_Request::getParam('action')."] and access is [".$this->access_allowed."]");
    	if (empty($this->access_allowed)) {
    		$this->access_allowed = false;
    	}
    	if ($this->access_allowed) {
            return true;
        }
    		
        if (self::is_logged_in()) {
            $post_vars = Pfw_Session::get('saved_post_vars');
            foreach ($post_vars as $key => $value) {
                $this->params[$key] = $value;
            }
            error_log("Session is already initialized, you are logged in");
            return true;
        }

        // if session is valid (not sexpired)
        // check to see saved_form isset and if so setup params with it
        // marshall post variables
        Pfw_Session::set('saved_post_vars', $_POST);
        Pfw_Session::set('saved_qs_vars', $_GET);

        // return true
        // if not send to login page
        // create session
        $action = Pfw_Request::getParam('action');
        $controller = Pfw_Request::getParam('controller');

        // marshall form post (in case we are in the middle of a post)
        // Not sure how to do this without stuffing the whole request in a session
        $this->redirect('/user/login?redir=/' . $controller . '/' . $action);
    }

    public static function is_logged_in() {
    	return Pfw_Session::get('is_logged_in');
    }

    function setupView()
    {
       	$view = $this->getView();
       	$view->assign('controller', Pfw_Request::getParam('controller'));
        if(self::is_logged_in())
       	{
       		# gettng user with profile photo
       		Pfw_Loader::loadModel('User');
    		$user = User::Q()->where(array('this.id = %s', Pfw_Session::get('login_id')))->exec();
    		$logged_in_user = $user[0];
            $view->assign('logged_in_user', $logged_in_user);
       		$view->assign('is_logged_in', true);
       	}
    }

    function sendOutput($output,$format='json') {
        ob_flush();
        if ($format == 'json') {
            $data = json_encode($output);
            header("Content-Type: application/json");
        }
        echo $data;
    } 
}
