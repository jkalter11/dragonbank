<?php

class Getstarted extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		//$this->load->model("advisorsclass");
		//$this->load->library('pagination');

		$this->ret['ret'] = "ret=advisors/getstarted";
		$this->record_count = 0;
	}

	/**
	 * @param $p: The page number.
	 */
	function index() {

		$this->data['pagebody']  = 'advisors/getstarted';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - Get Started';
		$this->data['pageheading'] = 'Get Started!';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/getstarted/';

		//$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */