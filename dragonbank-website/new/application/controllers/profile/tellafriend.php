<?php
/**
 * how.php Controller Class.
 */
class Tellafriend extends Application {

	function __construct(){
		parent::__construct();

		$this->vars = array(
			'full_name' => '',
			'email' => '',
			'cemail' => ''
		);
	}
	
	function index()
	{
		if (isset($_POST['tellfriend']))
		{
			$errors = array();
			$this->vars['full_name'] = trim($_POST['full_name']);
			if (strlen($this->vars['full_name']) == 0)
			{
				$errors['full_name'] = 'Full name cannot be blank';
			}

			$this->vars['email'] = trim($_POST['email_address']);
			$this->vars['cemail'] = trim($_POST['confirm_email']);
			if (strlen($this->vars['email']) == 0)
			{
				$errors['email'] = 'Email cannot be blank';
			}
			else if ($this->vars['email'] != $this->vars['cemail'])
			{
				$errors['cemail'] = 'Confirm email does not match';
			}

			if (count($errors))
			{
				$this->vars['error_vars'] = $errors;
				set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger', $errors);
			}
			else
			{
				sendNotification("An INCREDIBLE way to help kids learn about money on Dragon Bank, from " . $this->session->userdata('user_name'), sendTellAFriend($this->vars), $this->vars['email']);
				set_message("<strong>Success</strong> Your request has been sent", 'alert-success');
				header('Location: /profile/tellafriend');
				exit;
			}
		}

		$this->data['pagebody']  	= 'v2/tellfriend';
		$this->data['pagetitle'] 	= 'Tell A Friend';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Dragon Bank Purchase Profile Setup Enter Access Code Create Profile Spend Save Give Record Deposits withdrawls';
		//$data["addCSS"] = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		//$data["addJS"]	= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		//$this->load->vars($data);
		$this->load->vars($this->vars);
		$this->render();
	}
}

/* End of file how.php */
/* Location: ./application/controllers/how.php */