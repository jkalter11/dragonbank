<?php

class Clients extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		$this->load->model(array("parentsclass", "childrenclass"));
		//$this->load->library('pagination');
		$this->load->helper('advisor_stats');

		$this->ret['ret'] = "ret=advisors/clients";
		$this->record_count = 0;
	}

	/**
	 * @param $p: The page number.
	 */
	function index() {

		$this->data['pagebody']  = 'advisors/clients';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - My Clients';
		$this->data['pageheading'] = 'My Clients';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/clients/';


		$children = $this->childrenclass->getChildrenByAdvisorID($this->session->userdata('type_id'));

		foreach ($children as &$c)
		{
			$loginCount = $this->usertrackingclass->countUserLogins($c->child_user_id);
			$c->logincount = $loginCount;
		}

		$data['children'] = $children;

		$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}

	public function birthdays()
	{
		$this->data['pagebody']  = 'advisors/birthdays';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - My Clients - Birthdays';
		$this->data['pageheading'] = 'Birthdays This Month';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/clients/birthdays';

		$children = $this->childrenclass->getChildrenWithBirthdaysByAdvisorID($this->session->userdata('type_id'));

		$data['children'] = $children;

		foreach ($children as &$c)
		{
			$from = new DateTime($c->birthday);
			$to = new DateTime('today');

			$c->age = $from->diff($to)->y;

			$loginCount = $this->usertrackingclass->countUserLogins($c->child_user_id);
			$c->logincount = $loginCount;

		}

		$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */