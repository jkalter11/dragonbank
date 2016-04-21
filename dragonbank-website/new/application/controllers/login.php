<?php
ini_set('display_errors', 1);

/**
 * Login controller
 */
class Login extends Application {
	
	function __construct()
	{
		parent::__construct();
		$this->load->model( array('parentsclass', 'childrenclass', 'regionaldirectorsclass', 'advisorsclass', 'settingsclass', 'usertrackingclass') );
		$this->load->library("form_validation");
	}
	
	private function fail( $msg = "Please enter a username/email and password.")
	{
		flash_redirect("/new/login", status('', $msg, "red"), 'login_flash');
	}
	
	private function doLogin()
	{
		if( ! isset( $_POST['user'] ) || ! isset( $_POST['user_password'] ) )
			$this->fail();
		
		if( ( isset( $_POST['user'] ) && "" == $_POST['user'] ) || ( isset( $_POST['user_password'] ) && "" == $_POST['user_password'] ) )
			$this->fail();
			
		$email_user	= trim($_POST['user']);
		$password	= trim($_POST['user_password']);
		
		$this->form_validation->set_rules("user", "required|is_email");
		$this->form_validation->set_rules("user_password", "required|alpha_dash");
		
		if( ! $this->form_validation->run() )
		{
			$this->fail( validation_errors() );
		}


		$loginData = $this->usersclass->getUserByUsername($email_user);

		if ($loginData != null)
		{
			if ($loginData->user_group == 1)
			{
				$name_email = $loginData->user_email;
			}
			else if ($loginData->user_group == 2)
			{
				$typeID = $this->parentsclass->getParentIdByUserId($loginData->user_id);
				$name_email = $loginData->user_email;
			}
			else if ($loginData->user_group == 3)
			{
				$typeData = $this->childrenclass->getChildByUserId($loginData->user_id);
				$typeID = $typeData->child_id;
				$name_email = $loginData->user_name;
			}
			else if ($loginData->user_group == 5)
			{
				$typeData = $this->advisorsclass->getAdvisorByUserID($loginData->user_id);
				$typeID = $typeData->id;
				$name_email = $loginData->user_email;
			}
		
		}
		else
		{
			$this->fail( "Incorrect username/email." );
		}


		/*
		$parent = $this->usersclass->getOneWhere('user_email', trim( $email_user ) );
		$child	= $this->usersclass->getOneWhere('user_name', trim( $email_user ) );
		
		$parent_id 	= FALSE;
		$child_id	= FALSE;
		
		$drleid = 0;
		$paleid = 0;
		
		if( $parent && ! $child ) // Parent/admin login.
		{
			$user 		= $parent;
			$name_email = $user->user_email;
			$parent_id 	= $this->parentsclass->getParentIdByUserId( $user->user_id );
			$chimp		= $this->parentsclass->getOneWhere("parent_id", $parent_id, "dragon_newsletter");
			$drleid		= (int)$chimp;
		}
		else if( $child && ! $parent ) // Child login.
		{
			$user 		= $child;
			$name_email = $user->user_name;
			$child_id 	= $this->childrenclass->getChildIdByUserId( $user->user_id );
		}
		else // Incorrect username or email entered.
		{
			$this->fail( "Incorrect username/email." );
		}
		*/


		// Invalid password.
		if (md5($password) != $loginData->user_password)
		{
			$this->fail("Incorrect password.");
		}
		
		if ($loginData->status != 1 && $loginData->user_group == 2)
		{
			$this->fail("Your account has been suspended. Please contact Dragon Bank support for further details.");
		}
		
		if ($loginData->status != 1 && $loginData->user_group == 3 )
		{
			$this->fail("Uh Oh! Your account has changed. Please ask your parents to log into their account for more information.");
		}
		
		// Before we set session, lets check the site status.
		// If maintanence is set, only adim is allowed to login.
		if ((int)$this->settingsclass->getStatus() === 0 && $loginData->user_group != 1)
		{
			flash_redirect("/new/login", status('', "Site is under construction. Please try again later.", "orange"), 'login_flash');
		}

		// good to go, set session.
		$this->session->set_userdata(array(
			'user_id' 		=> $loginData->user_id, 
			'logged_in' 	=> TRUE, 
			'user_group'	=> $loginData->user_group, 
			'user_name'		=> $loginData->user_full_name,
			'initiated' 	=> TRUE,
			'name_email' 	=> $name_email,
			'user_status'	=> $loginData->status,
			'type_id'		=> $typeID,
			'phone' => $loginData->user_phone,
			//'parent_id'	=> $parent_id,
			//'child_id'		=> $child_id,
			//'drleid'		=> $drleid,
		));

		if (isset($typeData))
		{
			$this->session->set_userdata('typeData', (array) $typeData);
		}
		
		if( (int)$this->settingsclass->getStatus() === 0 && ! isAdmin())
		{
			flash_redirect("/new/login", status('', "Site is under construction. Please try again later.", "yellow"), 'login_flash');
		}

		// Stores the users login time in db.
		$this->session->set_userdata("tracking_id", $this->usertrackingclass->trackLoginTime($loginData->user_id));

		$this->go($loginData->user_group);
		exit();
	}
	
	private function go ($user_group)
	{
		if ($user_group == 2 || $user_group == 3)
		{	
			redirect("/new/profile/profile");
		}
		elseif ($user_group == 1)
		{
			redirect("/new/admin/dashboard");
		}
		elseif ($user_group == 5)
		{
			redirect("/new/advisors/dashboard");
		}
		
		exit();
	}
	
	function index()
	{
		if( $this->reqType("POST") )
		{
			$this->doLogin();
		}
		
		$this->data['pagebody']     = 'v2/login';
		$this->data['pagetitle']    = 'Login';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Login to dragon bank with your dragon username and password.';

		$this->render();
	}
}

/* End of file login.php */
/* Location: ./application/controllers/login.php */
