<?php

class Faq extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		//$this->load->model("advisorsclass");
		//$this->load->library('pagination');

		$this->ret['ret'] = "ret=advisors/faq";
		$this->record_count = 0;
	}

	/**
	 * @param $p: The page number.
	 */
	function index() {

		$this->data['pagebody']  = 'advisors/faq';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - FAQ';
		$this->data['pageheading'] = 'FAQ';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/faq/';

		//$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */