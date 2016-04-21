<?php
/**
 * signup2.php Controller Class.
 */
class Signup2 extends Application {
	
	private $vars;
	
    function __construct(){
        parent::__construct();
		$this->load->model( array('codesclass', 'parentsclass') );
		
		$this->vars = array(
			'ufirst' 		=> "",
            'ulast'         => "",
			'uemail' 		=> "",
			'phone' 		=> "",
			'cfirst' 		=> "",
            'clast'         => "",
			//'user' 			=> "",
			'birth' 		=> "",
			'gender' 		=> "Female",
			'allowance' 	=> (float)0.00,
			'paidon' 		=> "1",
			'init_deposit' 	=> "",
			//'kids' 			=> "",
			'ucemail' 		=> "",
			'freq'			=> "WEEKLY",
		);
    }
	
	// Callback function for codeigniter form validation.
	public function checkloggedin( $str )
	{
		if( isLoggedIn() && strlen($str) == 0 )
		{
			return TRUE;
		}
		elseif(strlen($str) > 0 && strlen($str) < 6 )
		{
			$this->form_validation->set_message('checkloggedin', 'The %s field must be at least 6 characters long');
			return FALSE;
		}
		elseif( ! isLoggedIn() && strlen($str) == 0 )
		{
			$this->form_validation->set_message('checkloggedin', 'The %s field is required');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function emailloggedin( $str )
	{
		if( isLoggedIn() && $str == $this->session->userdata('name_email') )
		{
			return TRUE;
		}
		elseif( isLoggedIn() && $this->session->userdata('name_email') != $str && $this->usersclass->fieldExists( "user_email",$str ) )
		{
			$this->form_validation->set_message('emailloggedin', 'The %s is already taken');
			return FALSE;
		}
		elseif( ! isLoggedIn() && strlen($str) == 0 )
		{
			$this->form_validation->set_message('emailloggedin', 'The %s field is required');
			return FALSE;
		}
		elseif( ! isLoggedIn() && $this->usersclass->fieldExists( "user_email", $str ) )
		{
			$this->form_validation->set_message('emailloggedin', 'The %s is already taken');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	/** 
	 *    Method is used to validate strings to allow alpha
	 *    numeric spaces underscores and dashes ONLY.
	 *    @param $str    String    The item to be validated.
	 *    @return BOOLEAN   True if passed validation false if otherwise.
	 */
	function alpha_dash_space($str_in = '')
	{
		if ( ! preg_match("/^([-a-z0-9_ ])*$/i", $str_in))
		{
			$this->form_validation->set_message('alpha_dash_space', 'The %s field may only contain alpha-numeric characters, spaces, underscores, and dashes.');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	function money($param) 
	{
		if( strlen( $param ) == 0 )
		{
			return true;
		}
		elseif( is_int($param) || is_float($param) || ! preg_match("/^\d+$|^\d+[\.]{1}\d+$/", $param) )
		{
			$this->form_validation->set_message('money', 'The %s field must be a money number: 0 OR 0.00');
			return false;	
		} 
		else 
		{
			return true;
		}
	}
	
	function validateSignup2()
	{
		
		$required = array(
			'check_parent_email' 				=> array('required', 'trim', 'msg' => "Verify Email"),
			'user_info[user_email]' 			=> array('trim', 'valid_email', 'matches[check_parent_email]', 'msg' => "email", 'callback_emailloggedin'),
			'check_parent_password'				=> array('trim', 'msg' => "check_password"),
			'user_info[user_password]' 			=> array('callback_alpha_dash_space', 'matches[check_parent_password]', 'msg' => "Password", 'callback_checkloggedin'),
			'user_info[user_first_name]' 		=> array('trim','callback_alpha_dash_space', 'required', 'msg' => "First Name"),
            'user_info[user_last_name]' 		=> array('trim','callback_alpha_dash_space', 'required', 'msg' => "Last Name"),
			'user_info[user_phone]' 			=> array('callback_alpha_dash_space', 'msg' => "phone"),
			//'user_info[kids]' 					=> array('is_natural', 'msg' => "kids"),
			'child_info[user_first_name]'		=> array('callback_alpha_dash_space','trim', 'required', 'msg' => "Child First Name"),
            'child_info[user_last_name]'		=> array('callback_alpha_dash_space','trim', 'required', 'msg' => "Child Last Name"),
			'child_info[birthday]' 				=> array('callback_alpha_dash_space','msg' => "Birthday"),
			'child_info[gender]' 				=> array('alpha','msg'=>"Gender"),
			
			/* Currently not in use. Do not remove.
			'child_info[user_name]' 			=> array('callback_alpha_dash_space','trim', 'required', 'is_unique[users.user_name]', 'msg' => "user name"),
			'check_child_password'				=> array('required', 'msg' => "child check password"),
			'child_info[user_password]' 		=> array('alpha_dash','required', 'trim', 'min_length[6]', 'matches[check_child_password]', 'msg' => "Child Password"),
			*/
			
			'child_info[allowance]'				=> array('trim', 'callback_money', 'msg' => 'Allowance'),
			'child_info[allowance_frequency]' 	=> array('trim', 'msg' => 'term'),
			'child_info[allowance_payday]' 		=> array('trim', 'msg' => 'payday'),
			'init_deposit'						=> array( 'callback_money','trim', 'msg' => 'Initial Deposit' ),
		);
		
		// Since set to false, will not call ->run().
		validateForm( $required, "signup3", FALSE );
		
		if( ! $this->form_validation->run() )
		{
			$this->vars['ufirst'] 		= set_value('user_info[user_first_name]');
            $this->vars['ulast'] 		= set_value('user_info[user_last_name]');
			$this->vars['uemail'] 		= set_value('user_info[user_email]');
			$this->vars['ucemail']		= set_value('check_parent_email');
			$this->vars['phone'] 		= set_value('user_info[user_phone]');
            $this->vars['cfirst'] 		= set_value('child_info[user_first_name]');
            $this->vars['clast'] 		= set_value('child_info[user_last_name]');
			//$this->vars['user'] 		= set_value('child_info[user_name]');
			$this->vars['birth'] 		= set_value('child_info[birthday]');
			$this->vars['gender'] 		= set_value('child_info[gender]');
			$this->vars['allowance'] 	= set_value('child_info[allowance]');
			$this->vars['paidon'] 		= set_value('child_info[allowance_payday]');
			$this->vars['init_deposit'] = set_value('init_deposit');
			//$this->vars['kids'] 		= set_value('user_info[kids]');
			$this->vars['freq'] 		= set_value('child_info[allowance_frequency]');
			
			$this->session->set_flashdata('flash', validation_errors("<span class='red'>", "<br /></span>") );
			
			$this->session->set_userdata('vars', $this->vars);
			redirect('signup2');
			return;
		}
		else
		{
			$this->session->set_userdata('signup2', TRUE);
			$this->session->set_userdata('init_deposit', (int)set_value('init_deposit') );
            $_POST['user_info']['user_full_name']   = set_value('user_info[user_first_name]') . " " . set_value('user_info[user_last_name]');
            $_POST['child_info']['user_full_name']  = set_value('child_info[user_first_name]') . " " . set_value('child_info[user_last_name]');
			$this->session->set_userdata('parent_info', $_POST['user_info']);
			$this->session->set_userdata('child_info', $_POST['child_info']);
			$this->session->unset_userdata('vars');
			
			redirect('signup3');
			exit();
		}
	}
    
    function index(){
		
		$cc = $this->codesclass;
		
		// Validates signup2 page post submit.
		// Important as without it, you could sign up with JavaScript disabled.
		if( ! $this->session->userdata('access_code') )
		{
			flash_redirect("signup", status('', "<span style='width: 585px;
			float: right;'>You session may have expired. Please try again.</span>", "red"), "flash");
		}
		
		if( $this->reqType("POST") )
		{
			$this->validateSignup2();
		}
		elseif( isLoggedIn() && ( $pid = (int)$this->session->userdata( 'type_id' ) ) )
		{
			$user = $this->usersclass->getUser( (int)$this->session->userdata('user_id') );
			$kids = $this->parentsclass->getKids( $pid );
			
			// Sets the parent's value if logged in.
			if( $user && ( $kids || $kids === 0 ) )
			{
				// Gets first and last name.
				$name = explode( " ", trim($user->user_full_name) );
				
				$this->vars['ufirst'] 	= $name[0];
				$this->vars['ulast']	= ( isset( $name[1] ) )? $name[1] : "";
				$this->vars['kids']		= (int)$kids;
				$this->vars['phone']	= $user->user_phone;
				$this->vars['uemail']	= $user->user_email;
				$this->vars['ucemail']	= $user->user_email;
			}
		}
		
		// We need to keep dragging this code along with us through the sign up process.
		$data['code'] 	= $this->session->userdata('access_code');

        $this->data['pagebody']  = 'v2/signup2';
        $this->data['pagetitle'] = 'Dragon Bank | Signup2 ';
		
		$data['addJS'] = "jquery.validate.min.js, validateForm.js";
		
		$this->load->vars($data);
		
		// We need to redirect in order to see error messages, so we stored values in session and are loading them.
		if( $this->session->userdata('vars') )
		{
			$this->load->vars($this->session->userdata('vars'));
		}
		else
		{
			$this->load->vars($this->vars);
		}
		
		
        $this->render();
    }
}

/* End of file signup2.php */
/* Location: ./application/controllers/signup2.php */