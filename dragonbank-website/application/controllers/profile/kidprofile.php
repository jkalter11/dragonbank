<?php
/**
 * kidprofile.php Controller Class.
 */
class Kidprofile extends Application {
	
	private $vars;
	
    function __construct(){
        parent::__construct();
		$this->load->model( array('childrenclass') );
		
		$this->vars = array(
			'allocation_type' 	=> 1,
		);
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
	
	private function validateChildProfile()
	{
		$required = array(
			//'check_child_password'		=> array('callback_alpha_dash_space', 'trim', 'msg' => "check child password"),
			//'child_info[user_password]' => array('matches[check_child_password]', 'msg' => "Child Password", 'callback_checkPassword'),
			'child_info[user_first_name]'=> array('callback_alpha_dash_space', 'trim', 'required', 'msg' => "Child First Name"),
            'child_info[user_last_name]'=> array('callback_alpha_dash_space', 'trim', 'required', 'msg' => "Child Last Name"),
			'child_info[birthday]' 		=> "Birthday",
			'child_info[gender]' 		=> "Gender",
			//'child_info[user_name]' 	=> array('callback_alpha_dash_space', 'trim', 'required', 'msg' => "user name", 'callback_uniqueUsername'),
			/*'child_info[allowance]'		=> array('trim', 'msg' => 'Allowance'),
			'child_info[allowance_frequency]' => array('trim', 'msg' => 'term'),
			'child_info[allowance_payday]' 	=> array('trim', 'msg' => 'payday'),*/		
		);
		
		// Helper function validateForm
		// Since set to false, will not call ->run().
		validateForm( $required, "profile/paretnsprofile", FALSE );
		
		// Call run here.
		// Retrieve all the values.
		if( ! $this->form_validation->run() )
		{
			//$this->vars['user_name'] 	= set_value('child_info[user_name]');
			$this->vars['birthday'] 	= set_value('child_info[birthday]');
			$this->vars['gender'] 		= set_value('child_info[gender]');
			$this->vars['allowance'] 	= set_value('child_info[allowance]');
			
			$this->session->set_flashdata('flash_child', validation_errors("<span class='red'>", "<br /></span>") );
			
			redirect('profile/kidprofile');
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
			
			flash_redirect("profile/kidprofile", status('', "<span style='width: 585px;
			float: right;'>Updated Successfully</span>", "green"), "flash_child");
		}
		else
		{
			flash_redirect("profile/kidprofile", status('', "Allocation must equal 100.00<br/>custom allocation equaled: $total", "red"), "flash_child");
		}
	}
	
	private function saveChild()
	{	
		// Set parent's child info.
		$rec = $this->sud->child_info;

		$rec = removeEmptyRecords( $rec );
		
		if( isset( $rec['user_password'] ) )
		{
			$rec['user_password'] = md5($rec['user_password']);
		}
		
		if( ! save_or_update('usersclass', 'user_id', 'Child', set_record('user', $rec) ) )
		{
			flash_redirect("profile/kidprofile", status('', "<span style='width: 585px;
			float: right;'>Update failed</span>", "red"), "flash_child");
		}
		
		// Save child.
		if( ! save_or_update('childrenclass', 'child_id', 'Child', set_record('children', $rec) ) )
		{
			flash_redirect("profile/kidprofile", status('', "<span style='width: 585px;
			float: right;'>Update failed</span>", "red"), "flash_child");
		}
		
		// Unset useless signup session data.
		$this->sud->child_info = "";
		
		return;
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
    
    function index(){
		
		if ($this->session->userdata('user_group') != 3)
		{
			header("Location: /new/profile/parentsprofile");
			exit;
		}

		$child = $this->session->userdata('typeData');

		$this->vars = array(
			'cfirst' => reset(explode(" ", trim($this->session->userdata('user_name')))),
			'clast' => end(explode(" ", trim($this->session->userdata('user_name')))),
			'birthday' => $child['birthday'],
			'gender' => $child['gender'],
			'freq' => $child['allowance_frequency'],
			'allowance' => $child['allowance'],
			'paidon' => $child['allowance_payday'],
			'spend' => $child['spend'],
			'save' => $child['save'],
			'give' => $child['give'],
			'profile_image' => $child['profile_image'],
			'allocation' => $child['allocation_type'],
			'supports' => $child['supports']
        );



		if (isset($_POST['child_submit']))
		{
			$errors = array();

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
				set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger', $errors);
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

				$this->db->where('user_id', $this->session->userdata('user_id'));
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
					setProfilePictureAchievement($this->session->userdata('type_id'));
				}

				$this->db->where('child_id', $this->session->userdata('type_id'));
				$this->db->update('children', $child);

				// bullshit Ron function.
				$this->setPaydate($this->session->userdata('type_id'), $this->vars['freq'], $this->vars['paidon']);



				$this->session->set_userdata('user_name', $this->vars['cfirst'] . ' ' . $this->vars['clast']);
				//$this->session->set_userdata('phone', $this->vars['phone']);
				//$this->session->set_userdata('name_email', $this->vars['uemail']);


				$typeData = $this->childrenclass->getChildByUserId($this->session->userdata('user_id'));
				$this->session->set_userdata('typeData', (array)$typeData);


				set_message("<strong>Success</strong> Your profile has been updated", 'alert-success');
				header('Location: /profile/kidprofile');
				exit;
			}
		}
		

        $this->data['pagebody']  = 'v2/kidprofile';
        $this->data['pagetitle'] = 'Dragon Bank | Kidprofile ';
		
		$data['addJS'] = "jquery.validate.min.js, validateForm.js, allocations.js";
		
		$this->load->vars($data);
		$this->load->vars($this->vars);

        $this->render();
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

}

/* End of file kidprofile.php */
/* Location: ./application/controllers/kidprofile.php */
