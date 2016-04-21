<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_checkemail extends Application {

	function __construct() {
		parent::__construct();
		$this->load->model(array('usersclass'));
	}
	
	function index() {
		
		if( isset($_GET['email'] ) && '' != $_GET['email'] )
		{
			$email = $_GET['email'];
		}
		else 
		{
			$data['status'] = FALSE;
			echo json_encode($data['status']);
			exit();
		}
		
		$unique = ! $this->usersclass->fieldExists( "user_email", $email );

		if( $unique )
		{
			// If the code is active and has not been used.
			$data['status'] = TRUE;
		}
		elseif( $this->session->userdata('name_email') == $email )
		{
			$data['status'] = TRUE;
		}
		else
		{
			$data['status'] = FALSE;
		}

		echo json_encode($data['status']);
		exit();
    }
}