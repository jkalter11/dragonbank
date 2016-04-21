<?php

/**
 * core/MY_Controller.php
 *
 * Default application controller
 *
 * @author		RLR
 * @copyright           2013, Ron L. Ross
 * ------------------------------------------------------------------------
 */
class Application extends CI_Controller {

	public $data 	= array();      	// parameters for view components
	protected $id;                  	// identifier for our content
	public $sud		= array();			// $this->session->userdata.
	

	/**
	 * Constructor.
	 * Establish view parameters & load common helpers
	 */
	function __construct() {
		parent::__construct();
		
		$this->data 			= array();
		$this->data['cntr'] 	= $cntr = $this->router->class;
		$this->data['title']	= 'Dragon Bank';
		$this->data['errors'] 	= array();
		$this->homepage			= "home";
		$this->sud 				= (object)$this->session->userdata;

		// Adds the jQuery script to set $this->session->userdata('timezone) with the user's timezone.
		if( ! $this->session->userdata('timezone') || strlen( $this->session->userdata('timezone') ) == 0 )
		{
			$data['addJS'] = "jstz-1.0.4.min.js, timezone.js";

			$this->load->vars($data);
		}

		// Sets the default timezone, if session has been set.
		if( strlen( $this->session->userdata('timezone') ) > 0 )
		{
			date_default_timezone_set( $this->session->userdata('timezone') );
		}
		
		if( isMaintenance() && ! $this->isLoginPage() )
		{
			$this->restrict( 1, "login", "Site is under going maintenance. Please come back later." );
		}
		
		// Checks for admin user if area is admin section.
		if( strcasecmp( the_folder(), 'admin' ) == 0 && $this->checkLoginStatus() )
		{
			// concurrently tracks users time. This helps keep the time accurate encase the user does not logout.
			if( $this->session->userdata('tracking_id') )
			{
				$this->usertrackingclass->trackLogoutTime( $this->session->userdata('tracking_id') );
			}

			// Admins only.
			$this->restrict( 1 );
			$this->data['session_id'] = $this->session->userdata('session_id');
		}
		
		// Checks for parent or child when accessing profiles.
		if( ( strcasecmp(the_folder(), 'profile') == 0 ) && $this->checkLoginStatus() )
		{
			if( ! isActive() )
			{
				// Destroys session.
				$this->session->sess_destroy();
				
				// Destroys all data as $this->data is a reference.
				$this->data = array();
				
				flash_redirect("login", status('', "Your Account is not active. Contact Dragon support.", "red"), 'login_flash');
			}

			// concurrently tracks users time. This helps keep the time accurate encase the user does not logout.
			if( $this->session->userdata('tracking_id') )
			{
				$this->usertrackingclass->trackLogoutTime( $this->session->userdata('tracking_id') );
			}


			// Parents and children only.
			$this->restrict( array( 2, 3 ) );
			$this->data['session_id'] = $this->session->userdata('session_id');
		}

		// Advisors
		if( ( strcasecmp(the_folder(), 'advisors') == 0 ) && $this->checkLoginStatus() )
		{

			if( ! isActive() )
			{
				// Destroys session.
				$this->session->sess_destroy();
				
				// Destroys all data as $this->data is a reference.
				$this->data = array();
				
				flash_redirect("login", status('', "Your Account is not active. Contact Dragon support.", "red"), 'login_flash');
			}

			// concurrently tracks users time. This helps keep the time accurate encase the user does not logout.
			if( $this->session->userdata('tracking_id') )
			{
				$this->usertrackingclass->trackLogoutTime( $this->session->userdata('tracking_id') );
			}

			// get companies data
			$this->load->model('companiesclass');
			$companyData = $this->companiesclass->getCompanyByAdvisorID($this->session->userdata('type_id'));
			$this->session->set_userdata('companyData', (array) $companyData);


			//$this->load->helper('advisor_messaging');

			$this->restrict(array(5));
			$this->data['session_id'] = $this->session->userdata('session_id');


			if (isset($_POST['sendquestionsideas']) && isset($_POST['questions-ideas']) && !empty($_POST['questions-ideas']))
			{
				sendNotification("Questions or Ideas from Advisor: " . $this->session->userdata('user_name'), sendQuestionsIdeas($_POST), $this->session->userdata("name_email"));

				set_message("<strong>Sucess</strong> Your question or idea has been submitted", 'alert-success');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		
	}

	/**
	 * Render this page
	 *
	 * @param $template: string template to render.
	 */
	function render($template = "v2/_template") {

		$data['menu']				= dynamicMenu();
		$this->data['main_menu'] 	= $this->load->view('_menubar', $data, true);
		$this->data['content'] 		= $this->parser->parse($this->data['pagebody'], $this->data, true);
		$this->data['data']    		= &$this->data;
		
		$this->parser->parse($template, $this->data);
	}
	
	/**
	 * Add or remove file names as necessary.
	 *
	 * @param (boolean): wheter to add the file or not.
	 * @return: returns array of file names.
	 */
	function addPhp($php = true){
		return ($php)? array(base_url().JS_PATH."manage.js.php", base_url().JS_PATH."help-box.js.php") : $php;
	}

	/**
	 * Checks login status.
	 *
	 * Return: boolean false if not logged in or controller class = 'welcome' OR 'login'. 
	 */
	function checkLoginStatus(){
		
		if($this->session->userdata('user_id') != '' && $this->session->userdata('session_id') != '' ){

			$this->checkBadSess();
			
			return true;
		}

		// Since no $this->session user_id and session_id, make sure session userdata logged_in and initialized are set to false.
		$this->session->set_userdata(array('logged_in' => false, 'initiated' => false));

		if($this->isLoginPage())
			return false;

		// Redirects to login page.
		flash_redirect("login", status("", "Please log in", "red"), 'login_flash');
		exit();
	}
	
	/**
	 * Prevents redirect loops.
	 */
	function isLoginPage(){
		return ( strcasecmp($this->data['cntr'], 'login') == 0 );
	}
	
	/**
	 * Destoys session and initializes userdata logged_in and initiated to false.
	 */
	function checkBadSess(){
		if( (! $this->session->userdata('logged_in')) || (! $this->session->userdata('initiated') )){
		
			$this->session->sess_destroy();
			$this->session->set_userdata(array('logged_in' => false, 'initiated' => false));
			
			// It is a bad session.
			if($this->isLoginPage())
				return true;

			// Redirects to login page.
			flash_redirect("login", status("", "Please log in", "red"), 'login_flash');
			exit();
		}
		
		// Not bad session.
		return false;
	}


	/**
	 * RBAC - role-based access control.
	 * Restrict the access of a page to only those users
	 * who have the role specified.
	 * 
	 * @param string $roleNeeded 
	 */
	function restrict($roleNeeded = null, $ret = "login", $msg = "You do not have permission to access that area.") {
	
		$userRole 	= $this->session->userdata('user_group');
		$allowed 	= FALSE;

		if( is_array( $roleNeeded ) )
		{
			foreach( $roleNeeded as $k => $v )
			{
				if( $v == $userRole )
				{
					$allowed = TRUE;
					break;
				}
			}
		}
		else
		{
			if( $userRole == $roleNeeded )
			{
				$allowed = TRUE;
			}
		}
		
		if( $allowed === FALSE )
		{
			flash_redirect($ret, status("", $msg, "red"), 'login_flash');
			exit;
		}
	}

	/**
	 * Are we logged in? 
	 */
	function loggedin() {
		return $this->session->userdata('user_id');
	}
	/**
	 * Checks $_SERVER['REQUEST_METHOD'] type.
	 */
	function reqType($type){
		if($_SERVER['REQUEST_METHOD'] == $type)
			return true;
		return false;
	}
}

/* End of file MY_Controller.php */
/* Location: application/core/MY_Controller.php */