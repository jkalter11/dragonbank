<?php

class Growmyprogram extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		//$this->load->model("advisorsclass");
		//$this->load->library('pagination');
		$this->load->helper('advisor_stats');

		$this->ret['ret'] = "ret=advisors/growmyprogram";
		$this->record_count = 0;
	}

	/**
	 * @param $p: The page number.
	 */
	function index() {

		$this->data['pagebody']  = 'advisors/growmyprogram';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - Grow My Program';
		$this->data['pageheading'] = 'Grow My Program';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/growmyprogram/';

		//$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */