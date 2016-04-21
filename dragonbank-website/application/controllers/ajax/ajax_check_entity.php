<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_check_entity extends Application {

	function __construct() {
		parent::__construct();
		
		if( !class_exists('codeslistclass') )
		{
			$this->load->model('codeslistclass');
		}
	}
	
	function index() {
		
		if( isset($_GET['codelistname'] ) && '' != $_GET['codelistname'] )
		{
			$entity = trim($_GET['codelistname']);
		}
		else 
		{
			$status = FALSE;
			echo json_encode($data['status']);
			exit();
		}
		
		$unique = ! $this->codeslistclass->fieldExists( "codelistname", $entity );

		if( $unique )
		{
			// If the code is active and has not been used.
			$status = TRUE;
		}
		else
		{
			$status = FALSE;
		}

		echo json_encode($status);
		exit();
    }
}