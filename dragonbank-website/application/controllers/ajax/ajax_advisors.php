<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_advisors extends Application {

	function __construct() {
		parent::__construct();
		$this->load->model('advisorsclass');
	}
	
	function index(){
		
		$data = array();
		$data['status'] = FALSE;

		if (isset($_GET['director']) && $_GET['director'] != 0)
		{
			$advisors = $this->advisorsclass->getAdvisorsByRD($_GET['director'], true);
			$advisors = $advisors->result();
			$data['advisors'] = $advisors;
			$data['status'] = TRUE;
		}
		

		echo json_encode($data);
		exit;
	}
}