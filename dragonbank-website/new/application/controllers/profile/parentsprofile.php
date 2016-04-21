<?php
/**
 * parentprofile.php Controller Class.
 */
class Parentsprofile extends Application {
	
	private $vars;
	
	function __construct(){
		parent::__construct();
		$this->load->model( array('childrenclass', 'parentsclass') );
		
		
	}
	
	// Callback function for codeigniter form validation.
	public function checkPassword( $str )
	{
		if( strlen($str) == 0 )
		{
			return TRUE;
		}
		elseif(strlen($str) > 0 && strlen($str) < 6 )
		{
			$this->form_validation->set_message('checkPassword', 'The %s field must be at least 6 characters long');
			return FALSE;
		}
		
		return md5( $str );
	}
	
	public function checkEmail( $str )
	{
		if( $str == $this->session->userdata('name_email') )
		{
			return TRUE;
		}
		elseif( $this->session->userdata('name_email') != $str && $this->usersclass->fieldExists( "user_email",$str ) )
		{
			$this->form_validation->set_message('checkEmail', 'The %s is already taken');
			return FALSE;
		}
		else
		{
			return TRUE;
		}
	}
	
	public function uniqueUsername( $str )
	{	
		if( strlen( $str ) == 0 )
		{
			$this->form_validation->set_message('uniqueUsername', 'The %s is required');
			return FALSE;
		}
		elseif( strlen( $str ) > 0 && strlen( $str ) < 4 )
		{
			$this->form_validation->set_message('uniqueUsername', 'The %s must be at least 4 characters long.');
			return FALSE;
		}
		
		$username 	= $_POST['child_info']['user_name'];
		$id 		= $_POST['child_info']['user_id'];
		
		$where = array( "user_name" => $username, "user_id" => $id );	
		
		if( ! $this->usersclass->getOneWhere( $where, NULL, "user_id") )
		{
			if( $this->usersclass->fieldExists("user_name", $username) )
			{
				$this->form_validation->set_message('uniqueUsername', 'Please select a different user name.');
				return FALSE;
			}
		}
		
		return TRUE;
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
		//conditional statements here
		if( is_int($param) || is_float($param) || ! preg_match("/^\d+$|^\d+[\.]{1}\d+$/", $param) )
		{
			$this->form_validation->set_message('money', 'The %s field must be a money number: 0 OR 0.00');
			return false;	
		} 
		else 
		{
			return true;
		}
	}
	
	function validateParentprofile()
	{
		
		$required = array(
			'check_parent_email' 		=> array('required', 'trim', 'msg' => "Verify Email"),
			'user_info[user_email]' 	=> array('trim', 'valid_email', 'matches[check_parent_email]', 'msg' => "email", 'callback_checkEmail'),
			'check_parent_password'		=> array('callback_alpha_dash_space', 'trim', 'msg' => "check_password"),
			'user_info[user_password]' 	=> array('matches[check_parent_password]', 'msg' => "Password", 'callback_checkPassword'),
			'user_info[user_first_name]' => array('callback_alpha_dash_space', 'trim', 'required', 'msg' => "First Name"),
			'user_info[user_last_name]' => array('callback_alpha_dash_space', 'trim', 'required', 'msg' => "Last Name"),
			'user_info[user_phone]' 	=> array('callback_alpha_dash_space', 'msg' => "phone"),
			//'user_info[kids]' 			=> array('numeric', 'msg'=>"kids"),			
		);
		
		// Helper function validateForm
		// Since set to false, will not call ->run().
		validateForm( $required, "profile/paretnsprofile", FALSE );
		
		// Call run here.
		// Retreive all the values.
		if( ! $this->form_validation->run() )
		{
			$this->vars['ufname'] 		= set_value('user_info[user_first_name]');
			$this->vars['ulname'] 		= set_value('user_info[user_last_name]');
			$this->vars['uemail'] 		= set_value('user_info[user_email]');
			$this->vars['ucemail']		= set_value('check_parent_email');
			$this->vars['phone'] 		= set_value('user_info[user_phone]');
			//$this->vars['user_name'] 	= set_value('child_info[user_name]');
			$this->vars['birthday'] 	= set_value('child_info[birthday]');
			$this->vars['gender'] 		= set_value('child_info[gender]');
			$this->vars['allowance'] 	= set_value('child_info[allowance]');
			//$this->vars['kids'] 		= set_value('user_info[kids]');
			
			$this->session->set_flashdata('flash_parent', validation_errors("<span class='red'>", "<br /></span>") );
			
			$this->session->set_userdata('vars', $this->vars);
			redirect('new/profile/parentsprofile');
			exit;
			return;
		}
		else
		{
			$_POST['user_info']['user_full_name'] = set_value('user_info[user_first_name]') . " " . set_value('user_info[user_last_name]');

			if( ! isset( $_POST['user_info']['allowance_status'] ) )
			{
				$_POST['user_info']['allowance_status'] = "0";
			}

			$this->sud->parent_info = $_POST['user_info'];

			$this->session->unset_userdata(array('vars' => ''));
			
			$this->saveParent();
		}
	}
	
	private function validateChildProfile()
	{
		$required = array(
			//'check_child_password'		=> array('trim', 'msg' => "check child password"),
			//'child_info[user_password]' => array('callback_alpha_dash_space', 'matches[check_child_password]', 'msg' => "Child Password", 'callback_checkPassword'),
			'child_info[user_first_name]' => array('callback_alpha_dash_space', 'trim', 'required', 'msg' => "First Name"),
			'child_info[user_last_name]' => array('callback_alpha_dash_space', 'trim', 'required', 'msg' => "Last Name"),
			'child_info[birthday]' 		=> "Birthday",
			'child_info[gender]' 		=> "Gender",
			//'child_info[user_name]' 	=> array('callback_alpha_dash_space', 'trim', 'required', 'msg' => "user name", 'callback_uniqueUsername'),
			'child_info[allowance]'		=> array('callback_money', 'trim', 'msg' => 'Allowance'),
			'child_info[allowance_frequency]' => array('trim', 'msg' => 'term'),
			'child_info[allowance_payday]' 	=> array('trim', 'msg' => 'payday'),			
		);
		
		// Helper function validateForm
		// Since set to false, will not call ->run().
		validateForm( $required, "new/profile/paretnsprofile", FALSE );
		
		// Call run here.
		// Retreive all the values.
		if( ! $this->form_validation->run() )
		{
			$this->vars['cfname'] 		= set_value('child_info[user_first_name]');
			$this->vars['clname'] 		= set_value('child_info[user_last_name]');
			//$this->vars['user_name'] 	= set_value('child_info[user_name]');
			$this->vars['birthday'] 	= set_value('child_info[birthday]');
			$this->vars['gender'] 		= set_value('child_info[gender]');
			$this->vars['allowance'] 	= set_value('child_info[allowance]');
			
			$this->session->set_flashdata('flash_child', validation_errors("<span class='red'>", "<br /></span>") );
			
			redirect('new/profile/parentsprofile');
			return;
		}
		else
		{
			$_POST['child_info']['user_full_name'] = set_value('child_info[user_first_name]') . " " . set_value('child_info[user_last_name]');
			$this->sud->child_info = $_POST['child_info'];

			$this->validateTotalSaveChild();
		}
	}
	
	function validateTotalSaveChild()
	{		
		$spend	= 0;
		$save	= 0;
		$give	= 0;
		$select = 0;
		
		if( isset( $_POST['child_info']['allocation_type'] ) )
		{
			$select = $_POST['child_info']['allocation_type'];
			$spend	= $_POST['child_info']['spend'][$select];
			$save	= $_POST['child_info']['save'][$select];
			$give	= $_POST['child_info']['give'][$select];
		}
		
		$total = number_format( ($spend + $save + $give), 2 );

		// The value amount equals 100.00, so continue to finish sign up process.
		if( (float)$total == 100.00 )
		{
			$this->sud->child_info['spend'] = $spend;
			$this->sud->child_info['save'] 	= $save;
			$this->sud->child_info['give'] 	= $give;
			
			// Sets the new profile image.
			if( isset( $_FILES['profile_image'] ) && $_FILES['profile_image']['size'] > 0 )
			{
				$this->sud->child_info['profile_image'] = $this->uploadImage();
			}
			
			// Save child
			$this->saveChild();
			
			flash_redirect("new/profile/parentsprofile", status('', "<span style='width: 585px;
			float: right;'>Updated Successfully</span>", "green"), "flash");
		}
		else
		{
			flash_redirect("new/profile/parentsprofile", status('', "Allocation must equal 100.00<br/>custom allocation equaled: $total", "red"), "flash_child");
		}
	}
	
	private function saveParent()
	{
		// Set parent's info.
		$rec = $this->sud->parent_info;

		//echo "<pre>"; print_r( $rec ); exit;

		// We need to verify the email through another function.
		unset( $rec['user_email'] );
		
		$rec['user_id'] = $rec['parent_user_id'] = (int)$this->sud->user_id;
		
		$rec['parent_id'] = (int)$this->sud->parent_id;
		
		$rec = removeEmptyRecords( $rec );

		//echo "<pre>"; print_r( $rec ); exit;

		if( ! save_or_update('usersclass', 'user_id', 'Parent', set_record('user', $rec)) )
		{
			flash_redirect("new/profile/parentsprofile", status('', "<span style='width: 585px;
			float: right;'>Update failed</span>", "red"), "flash_parent");
		}

		if( ! save_or_update('parentsclass', 'parent_id', 'Parent', set_record('parents', $rec)) )
		{
			flash_redirect("new/profile/parentsprofile", status('', "<span style='width: 585px;
			float: right;'>Update failed</span>", "red"), "flash_parent");
		}
		
		flash_redirect("new/profile/parentsprofile", status('', "<span style='width: 585px;
		float: right;'>Updated Successfully</span>", "green"), "flash_parent");
	}
	
	private function saveChild()
	{	
		// Set parent's child info.
		$rec = $this->sud->child_info;
		$cid = $rec['child_id'];
		$rec = removeEmptyRecords( $rec );

		//debug( $rec );
		if( ! save_or_update('usersclass', 'user_id', 'Child', set_record('user', $rec) ) )
		{
			flash_redirect("new/profile/parentsprofile", status('', "<span style='width: 585px;
			float: right;'>Update failed</span>", "red"), "flash_child");
		}

		// If the parent set an allowance and the frequency or day of week is different from the original. 
		if( isset( $rec['allowance'] ) && (float)$rec['allowance'] > 0.00 )
		{
			
			$c = $this->childrenclass->getChildAllowance( $cid );
			$f = $rec['allowance_frequency'];
			$d = (int)$rec['allowance_payday'];

			if( strcasecmp($f , $c->allowance_frequency) != 0 || strcasecmp($d , $c->allowance_payday) != 0 )
			{
				$this->setPaydate( $cid, $f, $d );
			}
		}
		
		// Save child.
		if( ! save_or_update('childrenclass', 'child_id', 'Child', set_record('children', $rec) ) )
		{
			flash_redirect("new/profile/parentsprofile", status('', "<span style='width: 585px;
			float: right;'>Update failed</span>", "red"), "flash_child");
		}
		
		// Unset useless signup session data.
		$this->sud->child_info = "";
		
		return;
	}
	
	private function setPaydate( $cid, $frequency, $d )
	{
		$today 	= date("Y-m-d");
		$time 	= strtotime( $today ); 		// Todays date timestamp format.
		$freq 	= strtolower($frequency); 	// Either week or month.
		
		/**
		 * We are configuring the date for the children's payday. We need to determine the whether or not 
		 * the payday has passed and whether the frequency is monthly or weekly. Once those have been 
		 * determined we can go ahead and set $time to the corresponding time value ( strtotime() ).   		 
		 */
		if( $freq == "month" )
		{
			$day = (int)date('d');
			
			if( $d > $day ) 	// Payday has not been missed this month.
			{
				$days = $d - $day;
				$time = strtotime("+$days days", $time);
			}
			elseif( $d < $day )	// Payday has passed for this month.
			{
				$days = $day - $d;
				$time = strtotime("-$days days", $time);
				$time = strtotime("+1 month", $time); 
			}
		}
		else
		{
			$dow = (int)date('w');
			
			if( $d > $dow ) 	// Payday has not been missed this week.
			{
				$days = $d - $dow;
				$time = strtotime("+$days days", $time);
			}
			elseif( $d < $dow )	// Payday has passed for this week.
			{
				$days = $dow - $d;
				$time = strtotime("-$days days", $time);
				$time = strtotime("+1 week", $time);
			}
		}
		
		$date = date("Y-m-d", $time);	// The resulting payday.
		
		$this->childrenclass->updatePaydate( $cid, $date );
	}
	
	//Upload Image function
	function uploadImage()
	{
		
		$config['upload_path']   	=   ROOT_FILE_PATH."/assets/images/profiles/";
		$config['allowed_types'] 	=   "gif|jpg|jpeg|png"; 
		$config['max_size']      	=   "5000";
		
		$this->load->library('upload', $config);
		
		if( ! $this->upload->do_upload('profile_image') )
		{
			
			echo $this->upload->display_errors();
			
		}
		else
		{
			
			$finfo = $this->upload->data();
			
			$config = array();
			
			$config['image_library'] 	= 'gd2';
			$config['source_image']		= ROOT_FILE_PATH."/assets/images/profiles/".$finfo['file_name'];
			$config['maintain_ratio'] 	= TRUE;
			$config['width']	 		= 104;
			$config['height']			= 136;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
			return $finfo['file_name'];
		}
		
	}
	
	private function changeEmail( $u )
	{
		if( ! isset( $u['user_email'] ) || strcmp( $this->sud->name_email, $u['user_email'] ) == 0 )
		{
			// Do nothing.
			return true;
		}
		
		$key = random_string(15, 3);
		
		$rec = array( 
			"email_verification_key" => md5( $key ),
			"email_parent_id"		 => $this->sud->parent_id,
			"email"					 => $u['user_email'],
		);

		$this->load->model("verifyemailclass");
		
		$id = $this->verifyemailclass->getId( $this->sud->parent_id );
		
		if( $id )
		{
			$rec['id'] = (int)$id;
		}
		
		if( save_or_update("verifyemailclass", "id", "", $rec ) )
		{
			sendNotification( "Dragon Bank | Verify Email", verifyEmailMsg( $key ), $u['user_email'] );
		}
	}
	
	private function alterCommunications( $u )
	{
		$this->load->helper('mailchimp');

		$drsub = array(
			'id'                => mailchimp_list_id("dragon"), // Get Dragon list id.
			'email'             => array('email' => $this->sud->name_email),
			'merge_vars'        => array('FNAME' => $this->sud->user_name),
			'update_existing'   => true,
			'replace_interests' => false,
		);

		if( isset( $u['dragon'] ) && (int)$this->sud->drleid == 0 )
		{
			$id = mailchimp_subscribe( $drsub );

			// Subscribes to dragon newsletter.
			$this->parentsclass->updateWhere(array("dragon_newsletter" => $id), 'parent_id', $this->sud->parent_id);

			$this->sud->dragon_newsletter = $id;
		}
		elseif( ! isset( $u['dragon'] ) && (int)$this->sud->drleid > 0 )
		{
			mailchimp_unsubscribe( $drsub );
			
			// Unsubscribes from dragon newsletter.
			$this->parentsclass->updateWhere(array("dragon_newsletter" => 0), 'parent_id', $this->sud->parent_id);

			$this->sud->dragon_newsletter = 0;
		}
		
		if( isset( $u['quarterly_reminder'] ) )
		{
			// Adds allowance reminder.
			$this->parentsclass->updateWhere(array("quarterly_reminder" => 1), 'parent_id', $this->sud->parent_id);
		}
		else
		{
			// Removes allowance reminder..
			$this->parentsclass->updateWhere(array("quarterly_reminder" => 0), 'parent_id', $this->sud->parent_id);
		}
		
		if( isset( $u['allowance_reminder'] ) )
		{
			// Adds allowance reminder.
			$this->parentsclass->updateWhere(array("allowance_reminder" => 1), 'parent_id', $this->sud->parent_id);
		}
		else
		{
			// Removes allowance reminder..
			$this->parentsclass->updateWhere(array("allowance_reminder" => 0), 'parent_id', $this->sud->parent_id);
		}
	}
	
	function index() {

		// restrict child access
		if ($this->session->userdata('user_group') != 2)
		{
			header('Location: /new/profile/profile');
			exit;
		}

		$pid = $this->session->userdata('type_id');
		$uid = $this->session->userdata('user_id');

		//$user 	= $this->usersclass->getUser($this->session->userdata('user_id'));
		$child 	= $this->childrenclass->getChildInfoByParent( $pid );
		$news	= $this->parentsclass->getNewsletters( $pid );


		
		$this->vars['ufname'] 	= reset(explode(" ", trim($this->session->userdata('user_name'))));
		$this->vars['ulname']   = end(explode(" ", trim($this->session->userdata('user_name'))));
		$this->vars['phone']	= $this->session->userdata('phone');
		$this->vars['uemail'] = $this->vars['ucemail']	= $this->session->userdata('name_email');
		$this->vars['child']	= $child;
		$this->vars['alstatus']	= $this->parentsclass->getAllowanceStatus( $pid );
		
		if (isset($_GET['child_id']) && is_numeric($_GET['child_id']))
		{
			$this->vars['curChild'] = $_GET['child_id'];
		}
		
		$this->vars['newsletter']	= $news->dragon_newsletter;
		$this->vars['qreminder']	= $news->quarterly_reminder;
		$this->vars['alreminder']	= $news->allowance_reminder;

		$errors = array();
		if (isset($_POST['parent_submit']))
		{
			$this->load->helper('mailchimp');

			$this->vars['ufname'] = trim($_POST['user_info']['user_first_name']);
			if (strlen($this->vars['ufname']) == 0)
			{
				$errors['ufname'] = 'Your first name cannot be blank';
			}

			$this->vars['ulname'] = trim($_POST['user_info']['user_last_name']);
			if (strlen($this->vars['ulname']) == 0)
			{
				$errors['ulname'] = 'Your last name cannot be blank';
			}

			if ($this->session->userdata('user_name') != $this->vars['ufname'] . ' ' . $this->vars['ulname'])
			{
				$updatemailchimpName = true;
			}

			$this->vars['phone'] = trim($_POST['user_info']['user_phone']);
			if (strlen($this->vars['phone']) == 0)
			{
				$errors['user_phone'] = 'Your phone number cannot be blank';
			}

			if ($this->vars['uemail'] != trim($_POST['user_info']['user_email']))
			{
				$this->vars['uemail'] = trim($_POST['user_info']['user_email']);
				$this->vars['ucemail'] = trim($_POST['check_parent_email']);
				if (strlen($this->vars['uemail']) == 0)
				{
					$errors['uemail'] = 'Your email cannot be blank';
				}
				else if ($this->vars['uemail'] != $this->vars['ucemail'])
				{
					$errors['ucemail'] = 'Your confirm email does not match';
				}
				$updatemailchimpEmail = true;
			}

			if (strlen($_POST['user_info']['user_password']) > 0)
			{
				$this->vars['upassword'] = $_POST['user_info']['user_password'];
				if (strlen($this->vars['upassword']) < 6)
				{
					$errors['upassword'] = 'Your password cannot be blank or less than 6 characters';
				}
				else if ($this->vars['upassword'] != $_POST['check_parent_password'])
				{
					$errors['ucpassword'] = 'Your confirm password does not match';
				}
				$updatepassword = true;
			}


			if (isset($_POST['comm_info']['dragon']))
			{
				$this->vars['newsletter'] = 1;
			}
			else
			{
				$this->vars['newsletter'] = 0;
			}

			if (isset($_POST['comm_info']['allowance_reminder']))
			{
				$this->vars['alreminder'] = 1;
			}
			else
			{
				$this->vars['alreminder'] = 0;
			}

			if (isset($_POST['comm_info']['quarterly_reminder']))
			{
				$this->vars['qreminder'] = 1;
			}
			else
			{
				$this->vars['qreminder'] = 0;
			}

			if (isset($_POST['comm_info']['allowance_status']))
			{
				$this->vars['alstatus'] = 1;
			}
			else
			{
				$this->vars['alstatus'] = 0;
			}


			if (count($errors))
			{
				$this->vars['error_vars'] = $errors;
				set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger', $errors);
			}
			else
			{
				$user = array(
					'user_full_name' => $this->vars['ufname'] . ' ' . $this->vars['ulname'],
					'user_email' => $this->vars['uemail'],
					'user_phone' => $this->vars['phone']
				);

				if (isset($updatepassword))
				{
					$user['user_password'] = md5($this->vars['upassword']);
				}

				$this->db->where('user_id', $uid);
				$this->db->update('users', $user);

				$parent = array(
					'allowance_reminder' => $this->vars['alreminder'],
					'quarterly_reminder' => $this->vars['qreminder'],
					'allowance_status' => $this->vars['alstatus']
				);

				$this->db->where('parent_id', $pid);
				$this->db->update('parents', $parent);


				// mailchimp

				// unsubscribe
				if ($this->vars['newsletter'] == 0 && $news->dragon_newsletter > 1)
				{

					$drsub = array(
						'id' => mailchimp_list_id("dragon"), // Get Dragon list id.
						'email' => array('email' => $this->session->userdata('name_email')),
						'delete_member' => true,
						'send_goodbye' => false,
						'send_notification' => false
					);


					mailchimp_unsubscribe($drsub);

					$parent = array(
						'dragon_newsletter' => 0
					);

					$this->db->where('parent_id', $pid);
					$this->db->update('parents', $parent);
					
				}

				// subscribe
				else if ($this->vars['newsletter'] == 1 && $news->dragon_newsletter == 0)
				{

					$drsub = array(
						'id' => mailchimp_list_id("dragon"), // Get Dragon list id.
						'email' => array('email' => $this->vars['uemail']),
						'merge_vars' => array('FNAME' => $this->vars['ufname'] . ' ' . $this->vars['ulname']),
						'update_existing' => true,
						'replace_interests' => false,
					);

					$drid = mailchimp_subscribe($drsub);

					
					$parent = array(
						'dragon_newsletter' => $drid
					);
					$this->db->where('parent_id', $pid);
					$this->db->update('parents', $parent);
				}

				// update
				else if (isset($updatemailchimpEmail) || isset($updatemailchimpName))
				{
					$drsub = array(
						'id' => mailchimp_list_id("dragon"), // Get Dragon list id.
						'email' => array('leid' => $news->dragon_newsletter),
						'merge_vars' => array(),
						'update_existing' => true,
						'replace_interests' => false,
					);

					if (isset($updatemailchimpName))
					{
						$drsub['merge_vars']['FNAME'] = $this->vars['ufname'] . ' ' . $this->vars['ulname'];
					}

					if (isset($updatemailchimpEmail))
					{
						$drsub['merge_vars']['new-email'] = $this->vars['uemail'];
					}

					$drid = mailchimp_update($drsub);

					// might not need to do this..
					$parent = array(
						'dragon_newsletter' => $drid
					);
					$this->db->where('parent_id', $pid);
					$this->db->update('parents', $parent);
				}


				$this->session->set_userdata('user_name', $this->vars['ufname'] . ' ' . $this->vars['ulname']);
				$this->session->set_userdata('phone', $this->vars['phone']);
				$this->session->set_userdata('name_email', $this->vars['uemail']);



				set_message("<strong>Success</strong> Your profile has been updated", 'alert-success');
				header('Location: /new/profile/parentsprofile');
				exit;
			}


		}


		if (isset($_POST['child_submit']))
		{
			$this->vars['curChild'] = $_POST['child_info']['child_id'];
			$child_id = $_POST['child_info']['child_id'];
			$child_user_id = $_POST['child_info']['user_id'];

			$this->vars['cfirst'] = trim($_POST['child_info']['user_first_name']);
			if (strlen($this->vars['cfirst']) == 0)
			{
				$errors['cfirst'] = "Your child's first name cannot be blank";
			}

			$this->vars['clast'] = trim($_POST['child_info']['user_last_name']);
			if (strlen($this->vars['clast'] ) == 0)
			{
				$errors['clast'] = "Your child's last name cannot be blank";
			}

			if (strlen($_POST['child_info']['user_password']) > 0)
			{
				$this->vars['cpassword'] = trim($_POST['child_info']['user_password']);
				if (strlen($this->vars['cpassword']) < 6)
				{
					$errors['cpassword'] = "Your child's password cannot be less than 6 characters or blank";
				}
				else if ($this->vars['cpassword'] != trim($_POST['check_child_password']))
				{
					$errors['ccpassword'] = "Your child's confirm password does not match";
				}
				$updatepassword = true;
			}
			

			$this->vars['birthday'] = trim($_POST['child_info']['birthday']);
			if (strlen($this->vars['birthday']) == 0)
			{
				$errors['birthday'] = "Your child's birthday cannot be blank";
			}

			$this->vars['gender'] = $_POST['child_info']['gender'];
			if ($this->vars['gender'] == '-')
			{
				$errors['gender'] = "Your child's gender cannot be blank";
			}

			$this->vars['allowance'] = trim($_POST['child_info']['allowance']);
			if (strlen($this->vars['allowance']) == 0)
			{
				$errors['allowance'] = "Your child's allowance cannot be blank";
			}
			else if ($this->vars['allowance'] < 0)
			{
				$errors['allowance'] = "Your child's allowance cannot be a negative value";
			}
			else if (!is_numeric($this->vars['allowance']))
			{
				$errors['allowance'] = "Your child's allowance must be a number";
			}

			$this->vars['paidon'] = $_POST['child_info']['allowance_payday'];
			if ($this->vars['paidon'] == '-')
			{
				$errors['paidon'] = "Your child's pay day cannot be blank";
			}

			//var_dump($_POST['child_info']['allowance_frequency']);
			//exit;

			$this->vars['freq'] = $_POST['child_info']['allowance_frequency'];
			if ($this->vars['freq'] == '-')
			{
				$errors['freq'] = "Your child's allowace frequency cannot be blank";
			}


			$this->vars['allocation'] = $_POST['child_info']['allocation_type'];
			$this->vars['spend'] = trim($_POST['child_info']['spend'][(string)$this->vars['allocation']]);
			$this->vars['save'] = trim($_POST['child_info']['save'][(string)$this->vars['allocation']]);
			$this->vars['give'] = trim($_POST['child_info']['give'][(string)$this->vars['allocation']]);
			if ($this->vars['allocation'] == 4)
			{

				if ($this->vars['spend'] < 0)
				{
					$errors['spend'] = 'Spend cannot be a negative value';
				}
				else if (!is_numeric($this->vars['spend']))
				{
					$errors['spend'] = 'Spend must be a number';
				}

				if ($this->vars['save'] < 0)
				{
					$errors['save'] = 'Save cannot be a negative value';
				}
				else if (!is_numeric($this->vars['save']))
				{
					$errors['save'] = 'Save must be a number';
				}

				if ($this->vars['give'] < 0)
				{
					$errors['give'] = 'Give cannot be a negative value';
				}
				else if (!is_numeric($this->vars['give']))
				{
					$errors['give'] = 'Give must be a number';
				}

				if (
					is_numeric($this->vars['spend']) && is_numeric($this->vars['save']) && is_numeric($this->vars['give']) &&
					($this->vars['spend'] + $this->vars['save'] + $this->vars['give'] != 100)
				)
				{
					$errors['total'] = 'Spend, save, and give must equal 100%';
				}
			}



			if (count($errors))
			{
				$this->vars['error_vars'] = $errors;
				set_message("<strong>Error</strong> There is a problem with your child's submission", 'alert-danger', $errors);
			}
			else
			{
				// Sets the new profile image.
				if (isset($_FILES['profile_image']) && $_FILES['profile_image']['size'] > 0)
				{
					$image = $this->uploadImage();
				}

				// create user record for child
				$user = array(
					'user_full_name' => $this->vars['cfirst'] . ' ' . $this->vars['clast']
				);

				if (isset($updatepassword))
				{
					$user['user_password'] = md5($this->vars['cpassword']);
				}

				$this->db->where('user_id', $child_user_id);
				$this->db->update('users', $user);

				
				// create child record
				$child = array(
					'gender' => $this->vars['gender'],
					'birthday' => $this->vars['birthday'],
					'allowance' => $this->vars['allowance'],
					'spend' => $this->vars['spend'],
					'save' => $this->vars['save'],
					'give' => $this->vars['give'],
					'allowance_frequency' => $this->vars['freq'],
					'allowance_payday' => $this->vars['paidon'],
					'allocation_type' => $this->vars['allocation']
				);

				if (isset($image))
				{
					$child['profile_image'] = $image;
					setProfilePictureAchievement($child_id);
				}

				$this->db->where('child_id', $child_id);
				$this->db->update('children', $child);

				// bullshit Ron function.
				$this->setPaydate($child_id, $this->vars['freq'], $this->vars['paidon']);
		




				set_message("<strong>Success</strong> Your child's profile has been updated", 'alert-success');
				header('Location: /new/profile/parentsprofile?child_id=' . $this->vars['curChild']);
				exit;
			}
		}






		/*
		if( $this->reqType("POST") )
		{
			if( isset($_POST['user_info']) )
			{
				// Checks for changes in the email notification settings.
				$this->alterCommunications( $_POST['comm_info'] );

				// Does nothing if the email is the same.
				$this->changeEmail( $_POST['user_info'] );
				
				$this->validateParentprofile();
			}
			else
			{
				$this->validateChildProfile();
			}
		}
		
		if( ! ( $pid = (int)$this->sud->type_id ) )
		{
			flash_redirect(BASE_URL()."login", status('', "<span>Please login</span>", "red"), "login_flash");
		}
		*/
		
		

		$this->data['pagebody']  = 'v2/parentsprofile';
		$this->data['pagetitle'] = 'Dragon Bank | Parentprofile ';
		
		$data['addJS'] = "allocations.js";
		
		$this->load->vars($data);
		$this->load->vars($this->vars);

		$this->render();
	}
}

/* End of file parentprofile.php */
/* Location: ./application/controllers/parentprofile.php */
