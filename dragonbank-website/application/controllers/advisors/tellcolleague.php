<?php

class Tellcolleague extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		//$this->load->model("advisorsclass");
		//$this->load->library('pagination');

		$this->ret['ret'] = "ret=advisors/tellcolleague";
		$this->record_count = 0;
	}

	function sendColleaugeEmail()
	{
		sendNotification("Invite to Dragon Bank, from: " . $this->session->userdata('user_name'), sendColleagueEmail($_POST), $_POST['email']);

		set_message("<strong>Sucess</strong> Your form has been submitted", 'alert-success');
		redirect('/advisors/tellcolleague');
	}

	/**
	 * @param $p: The page number.
	 */
	function index() {
		$data['name'] = $data['email'] = '';
		if (isset($_POST['colleaguesend']))
		{

			$errors = array();
			$data['name'] = $_POST['name'];
			$data['email'] = $_POST['email'];


			if (empty($data['name']))
			{
				$errors['name'] = 'Name is blank';
			}

			if (empty($data['email']))
			{
				$errors['email'] = 'Email is blank';
			}

			if (count($errors))
			{
				$data['error_vars'] = $errors;
				set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger');
			}
			else
			{
				$this->sendColleaugeEmail();
			}

			//redirect('/advisors/thanks');
		}

		$this->data['pagebody']  = 'advisors/tellcolleague';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - Tell My Colleagues';
		$this->data['pageheading'] = 'Tell My Colleague';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dragonbank.com/advisors/tellcolleague/';

		$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */