<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_regionaldirectors extends Application {

	function __construct() {
		parent::__construct();
		$this->load->model('regionaldirectorsclass');
	}
	
	function index(){
		
		$data = array();
		$data['status'] = FALSE;

		if (isset($_GET['company']) && $_GET['company'] != 0)
		{
			$directors = $this->regionaldirectorsclass->getDirectorsByCompany($_GET['company'], true);
			$directors = $directors->result();
			$data['directors'] = $directors;
			$data['status'] = TRUE;
		}
		

		echo json_encode($data);
		exit;
    }
}