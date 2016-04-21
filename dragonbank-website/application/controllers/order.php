<?php
/**
 * order.php Controller Class.
 */
class Order extends Application {
	
	private $vars 			= array();
	private $captcha_path 	= "";
	private $captcha_url	= "";

    function __construct(){
        parent::__construct();
		
		$this->load->helper( array('captcha', 'form') );
		$this->load->library('form_validation');
		
		$this->vars = array(
			'fname' 	=> "",
			'lname'		=> "",
			'postal'	=> "",
			'address'	=> "",
			'city'		=> "",
			'prov'		=> "",
			'company' 	=> "", 
			'email' 	=> "",
			'phone' 	=> "", 
			'message' 	=> "", 
			'captcha' 	=> "",
			'quantity'      => "",
			'cemail'	=> ""
		);

		$this->captcha_path = ROOT_FILE_PATH . '/assets/images/captcha/';
		$this->captcha_url	= ASS_IMG_PATH . "captcha/";
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
   
	/* The default function that gets called when visiting the page */
	public function validateForm()
	{
    
		/* Set a few basic form validation rules */
		$this->form_validation->set_rules('fname', "Name", 'required');
		$this->form_validation->set_rules('lname', "Name", 'required');
		$this->form_validation->set_rules('captcha', "Captcha", 'required');
		$this->form_validation->set_rules('email', "Email", 'is_email|required');
		$this->form_validation->set_rules('phone', "Phone", 'trim');
		$this->form_validation->set_rules('address', "Address", 'trim');
		$this->form_validation->set_rules('city', "City", '');
		$this->form_validation->set_rules('postal', "Postal/Zip", 'trim');
		$this->form_validation->set_rules('prov', "Province/State", 'trim');
		$this->form_validation->set_rules('company', "Company", '');
		$this->form_validation->set_rules('message', "Message", 'required');
		$this->form_validation->set_rules('check-email', "Check Email", '');
		
		$valid = $this->form_validation->run();
		
		/* Get the user's entered captcha value from the form */
		$userCaptcha = set_value('captcha');
		
		/* Get the actual captcha value that we stored in the session (see below) */
		$word = $this->session->userdata('captchaWord');

		/* Check if form (and captcha) passed validation*/
		if ( $valid === TRUE && strcmp( strtoupper( $userCaptcha ), strtoupper( $word ) ) == 0 )
		{
			/* Clear the session variables */
			$this->session->unset_userdata('captchaWord');
			$this->session->unset_userdata('image');

            $info = array(
                'fname'     => set_value('fname'),
                'lname'     => set_value('lname'),
                'email'     => set_value('email'),
                'address'   => set_value('address'),
                'city'      => set_value('city'),
                'prov'      => set_value('prov'),
                'postal'    => set_value('postal'),
                'company'   => set_value('company'),
                'phone'     => set_value('phone'),
                'message'   => set_value('message'),
            );
			
			if( sendNotification( "Customer Order", orderMsg($info), site_email() ) )
			{
				// Sets flashdata and redirects safely.
				flash_redirect('order', status('', 'Thank you for your interest in ordering Dragon Bank. We will be in touch shortly to confirm your order', 'green') );
			}
			else
			{
				// Sets flashdata and redirects safely.
				flash_redirect('order', status('', 'Email could not be sent. Please try again.', 'red') );
			}
		}
		else
		{
			/* Get the user's name from the form */
			$this->vars['fname'] 	= set_value('fname');
			$this->vars['lname'] 	= set_value('lname');
			$this->vars['company'] 	= set_value('company');
			$this->vars['city'] 	= set_value('city');
			$this->vars['address'] 	= set_value('address');
			$this->vars['prov'] 	= set_value('prov');
			$this->vars['postal'] 	= set_value('postal');
			$this->vars['email'] 	= set_value('email');
			$this->vars['cemail'] 	= set_value('check-email');
			$this->vars['phone'] 	= set_value('phone');
			$this->vars['message'] 	= set_value('message');
			$this->vars['captcha']	= set_value('captcha');
			$this->session->set_flashdata('flash','<div style=\'color:red;\'>Please enter a valid verfication code</div>');
		}
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
	
    function index()
	{
		if( $this->reqType("POST") )
		{
			$this->validateForm();
		}
		
        $this->data['pagebody']  	= 'v2/order';
        $this->data['pagetitle'] 	= 'Order Dragon Bank Now';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'To place an order for the Dragon Bank, please fill out the form on the right to send us your request. Someone will contact you within 1 business day.';
		
		$this->vars['addJS'] = "jquery.validate.min.js, validateForm.js, captcha.js";
		$this->setForm();
		
		$this->load->vars($this->vars);
		
        $this->render();
    }
}

/* End of file order.php */
/* Location: ./application/controllers/order.php */
