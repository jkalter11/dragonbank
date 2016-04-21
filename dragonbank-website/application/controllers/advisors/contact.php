<?php

class Contact extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		//$this->load->model("advisorsclass");
		//$this->load->library('pagination');
		//$this->load->helper('advisor_messaging');

		$this->ret['ret'] = "ret=advisors/contact";
		$this->record_count = 0;
	}

	public function sendContactEmail()
	{

		sendNotification("Contact Email from Advisor: " . $this->session->userdata('user_name'), sendContactEmail($_POST), $this->session->userdata("name_email"));

		set_message("<strong>Sucess</strong> Your contact us form has been submitted", 'alert-success');
		redirect('/advisors/contact');
	}

	/**
	 * @param $p: The page number.
	 */
	function index() {

		if (isset($_POST['contactsend']))
		{
			$this->sendContactEmail();
			//redirect('/advisors/thanks');
		}

		$this->data['pagebody']  = 'advisors/contact';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - Contact Us';
		$this->data['pageheading'] = 'Contact Us: Help';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dragonbank.com/advisors/contact/';


		$this->data['growmyprogram'] = '';

		if (isset($_GET['h']) && ($_GET['h'] == 1 || $_GET['h'] == 2 || $_GET['h'] == 3))
		{
			if ($_GET['h'] == 1)
			{
				$this->data['growmyprogram'] = 'I would like some help learning how I can reach even more kids with this Dragon Bank Program. Please contact me to discuss.';
			}
			else if ($_GET['h'] == 2)
			{
				$this->data['growmyprogram'] = 'I am very interested in expanding my program to help reach older kids, including teens and young adults. Please contact me to discuss what options you have for this group of kids.';
			}
			else if ($_GET['h'] == 3) 
			{
				$this->data['growmyprogram'] = 'I would like some tips and tactics to ensure I am getting the most from my Dragon Bank Program. Please contact me to discuss.';
			}
		}

		//$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */