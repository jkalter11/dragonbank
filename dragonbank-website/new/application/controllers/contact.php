<?php
/**
 * contact.php Controller Class.
 */
class Contact extends Application {

	// settings
	protected 	$sendEmailTo 		= 	'ron@604media.com';
	//protected	$sendEmailTo		= 	"susan@enrichedacademy.com";
	protected	$subjectLine 		= 	"Dragon Bank - Contact Request";

	// spam protection
	protected	$spam_protection	= 	true; // true or false
	protected 	$spam_question		=	'What color is a blue snake';
	protected	$spam_answer		= 	'blue';

	function __construct(){
		parent::__construct();

		$this->load->helper( array('captcha', 'form') );

		$this->captcha_path = ROOT_FILE_PATH . '/assets/images/captcha/';
		$this->captcha_url	= ASS_IMG_PATH . "captcha/";

		$this->vars = array(			
			'contact_name' 		=> "",
			'contact_email'         => "",
			'contact_number' 		=> "",
			'contact_message' 		=> ""
		);

	}

	// Used for refreshing the capthca via jQuery.
	public function new_captcha()
	{
		$this->load->helper('file');

		// Generates 6 random uppercase letters.
		$rand = strtoupper( random_string(6, 6) );

		$captcha = create_captcha(array(
			'img_path'    	=> $this->captcha_path,
			'img_url'    	=> $this->captcha_url,
			'img_width'	 	=> 110,
			'img_height' 	=> 25,
			'word'			=> $rand
		));

		$this->session->set_userdata('captchaWord', $captcha['word']);
		$filename = $this->captcha_path . $captcha['time'] . '.jpg';
		$this->output->set_header('Expires: Sat, 26 Jul 1997 05:00:00 GMT');
		$this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate, max-age=0');
		$this->output->set_header('Cache-Control: post-check=0, pre-check=0', FALSE);
		$this->output->set_header('Pragma: no-cache');
		$this->output->set_header('Content-Type: image/jpeg');
		$this->output->set_header('Content-Length: ' . filesize($filename));
		echo read_file($filename);
	}

	public function setForm()
	{

		/** Validation was not successful - Generate a captcha **/

		$rand = strtoupper( random_string(6, 6) );

		/* Setup vals to pass into the create_captcha function */
		$vals = array(
			'img_path' 		=> $this->captcha_path,
			'img_url' 		=> $this->captcha_url,
			'img_width'	 	=> 110,
			'img_height' 	=> 25,
			'word'			=> $rand
		);

		/* Generate the captcha */
		$captcha = create_captcha($vals);

		/* Store the captcha value (or 'word') in a session to retrieve later */
		$this->session->set_userdata('captchaWord', $captcha['word']);
		$this->session->set_userdata('image', $captcha['image']);
	}

	public function sendContactEmail()
	{
		if (isLoggedIn())
		{
			sendNotification("Contact Email from Parent: " . $this->session->userdata('user_name'), sendContactEmail($_POST, false), "support@enrichedacademy.com");
		}
		else
		{
			sendNotification("Contact Email from Dragonbank", sendContactPublicEmail($_POST), "support@enrichedacademy.com");
		}

		set_message("<strong>Sucess</strong> Your contact us form has been submitted", 'alert-success');
		redirect('/contact');
	}

	public function index() {

		if (isLoggedIn())
		{
			$this->data['pagebody']  	= 'v2/contact';
		}
		else
		{
			$this->data['pagebody']  	= 'v2/contact-public';
		}

		$this->data['pagetitle'] 	= 'Dragon Bank - Contact Us';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'The Dragon Bank is a fantastic investment in your child’s financial future start saving the Dragon Way TODAY!';

		/*
		$this->data['show_spam_protection'] = $this->spam_protection; // used in the view
		$this->data['spam_question'] 		= $this->spam_question; // used in the view
		$this->data['flash'] 				= "";

		$this->load->library('form_validation');
		$this->load->helper('url');

		$this->form_validation->set_rules('name', 'Name', 'trim|required');
		$this->form_validation->set_rules('email', 'Email', 'trim|required|valid_email');
		$this->form_validation->set_rules('message', 'Message', 'trim|required|xss_clean');
		$this->form_validation->set_rules('captcha', "Captcha", 'required');
		*/


		if (isset($_POST['contactsend']))
		{	
			$errors = array();

			if (!isLoggedIn())
			{
				$this->vars['contact_name'] = trim($_POST['contact_name']);
				if (strlen($this->vars['contact_name']) == 0)
				{
					$errors['contact_name'] = 'Your name cannot be blank';
				}

				$this->vars['contact_email'] = trim($_POST['contact_email']);
				if (strlen($this->vars['contact_email']) == 0)
				{
					$errors['contact_email'] = 'Your email cannot be blank';
				}

				$this->vars['contact_number'] = trim($_POST['contact_number']);

				$this->vars['contact_message'] = trim($_POST['contact_message']);
				if (strlen($this->vars['contact_message']) == 0)
				{
					$errors['contact_message'] = 'Your message cannot be blank';
				}


				if (count($errors))
				{
					$this->vars['error_vars'] = $errors;
					set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger', $errors);
				}
			}

			if (isLoggedIn() || (!isLoggedIn() && count($errors) == 0))
			{
				$this->sendContactEmail();
			}
			//redirect('/advisors/thanks');
		}

		// if( $this->reqType("POST") )
		// {
			

		// 	/* Get the user's entered captcha value from the form */
		// 	$userCaptcha = trim($_POST['captcha']);

		// 	/* Get the actual captcha value that we stored in the session (see below) */
		// 	$word = trim($this->session->userdata('captchaWord'));

		// 	if( $this->form_validation->run() )
		// 	{
		// 		if( strcmp( strtoupper( $userCaptcha ), strtoupper( $word ) ) == 0 )
		// 		{
		// 			/* Clear the session variables */
		// 			$this->session->unset_userdata('captchaWord');
		// 			$this->session->unset_userdata('image');

		// 			// success! email it, assume it sent, then show contact success view.

		// 			$this->load->library('email');
		// 			$this->email->from($this->input->post('email'), $this->input->post('name'));
		// 			$this->email->to($this->sendEmailTo);
		// 			$this->email->subject($this->subjectLine);
		// 			$this->email->message($this->input->post('message'));

		// 			if( $this->email->send() )
		// 			{
		// 				$this->data['flash'] = "<span style='color: green'>Thank you for contacting us. A representative will reply to you shortly.</span>";
		// 			}
		// 			else
		// 			{
		// 				$this->data['flash'] =  "<span style='color: red'>Failed to send email. Please try again.</span>";
		// 			}
		// 		}
		// 		else
		// 		{
		// 			$this->data['flash'] =  "<span style='color: red'>Please enter a valid verfication code</span>";
		// 		}


		// 	}
		// }

		$this->vars['addJS'] = "jquery.validate.min.js, validateForm.js, captcha.js";
		//$this->setForm();

		$this->load->vars($this->vars);

		$this->render();
	}
}

/* End of file contact.php */
/* Location: ./application/controllers/contact.php */