<?php
/**
 * how.php Controller Class.
 */
class Activities extends Application {

	function __construct(){
		parent::__construct();
		$this->load->model('activities');
	}
	
	function index(){
		$this->data['pagebody']  	= 'v2/activities';
		$this->data['pagetitle'] 	= 'Activities';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Dragon Bank Purchase Profile Setup Enter Access Code Create Profile Spend Save Give Record Deposits withdrawls';
		//$data["addCSS"] = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		//$data["addJS"]	= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		//$this->load->vars($data);
		$this->render();
	}
}

/* End of file how.php */
/* Location: ./application/controllers/how.php */