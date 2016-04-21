<?php
/**
 * signup.php Controller Class.
 */
class Signup extends Application {

	function __construct(){
		parent::__construct();
		$this->load->model(array('codesclass', 'parentsclass', 'childrenclass'));

		$this->vars = array(
						
			'ufirst' 		=> "",
			'ulast'         => "",
			'uemail' 		=> "",
			'phone' 		=> "",
			'cfirst' 		=> "",
			'ulast'         => "",
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
	
	public function index()
	{

		if (isset($_POST['code']) && !empty($_POST['code']))
		{
			if ($this->session->userdata('user_group') != false && $this->session->userdata('user_group') == 3)
			{
				set_message("<strong>Error</strong> Please log in as a parent to use this code.", 'alert-danger');
				header('Location: /new/signup');
				exit;
			}


			$data = $this->codesclass->codeStatusByName($_POST['code']);

//            if ($data != false) bug=========
			if ($data != false && isset($data->status) && !empty($data->status) && $data->status == 1)
			{
				$this->session->set_userdata("access_code", $_POST['code']);
				$this->session->set_userdata('code_id', $data->id);


				if (isset($data->advisor_id) && !empty($data->advisor_id))
				{
					$this->session->set_userdata("advisor_id", $data->advisor_id);
				}
				
				header('Location: /new/signup/step2');
				exit;
			}

			set_message("<strong>Error</strong> The code you entered is invalid. Please try again.", 'alert-danger');
		}

		$this->data['pagebody']  	= 'v2/signup';
		$this->data['pagetitle'] 	= 'Signup ';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Signup with dragon bank today. Use access code and begin your childs spend, save, give money.';
		
		//$data['addJS'] = "jquery.validate.min.js, validateForm.js";
		//$this->load->vars($data);
		
		$this->render();
	}

	public function step2()
	{

		if (!$this->session->userdata('access_code'))
		{
			header('Location: /new/signup');
			exit;
		}

		$this->vars = array(			
			'ufirst' 		=> "",
			'ulast'         => "",
			'uemail' 		=> "",
			'upassword'		=> '',
			'phone' 		=> "",
			'newsletter' => '0',
			'alreminder' => '0',
			'qreminder' => '0',
			'alstatus' => '0',
			'cfirst' 		=> "",
			'clast'         => "",
			'cusername' 	=> "",
			'cpassword'		=> '',
			'birthday' 		=> "",
			'gender' 		=> "",
			'allowance' 	=> '',
			'paidon' 		=> "1",
			'init_deposit' 	=> "",
			//'kids' 			=> "",
			'ucemail' 		=> "",
			'freq'			=> "",
			'code_id' => $this->session->userdata('code_id'),
			//'code'	=> $this->session->userdata('access_code')
		);


		if (isset($_POST['activate_step2']))
		{

			$errors = array();

			if (isset($_POST['user_info']))
			{
				$this->vars['ufirst'] = trim($_POST['user_info']['user_first_name']);
				if (strlen($this->vars['ufirst']) == 0)
				{
					$errors['ufirst'] = 'Your first name cannot be blank';
				}

				$this->vars['ulast'] = trim($_POST['user_info']['user_last_name']);
				if (strlen($this->vars['ulast']) == 0)
				{
					$errors['ulast'] = 'Your last name cannot be blank';
				}

				$this->vars['uemail'] = trim($_POST['user_info']['user_email']);
				if (strlen($this->vars['uemail']) == 0)
				{
					$errors['uemail'] = 'Your must enter your email';
				}
				else if ($this->vars['uemail'] != trim($_POST['check_parent_email']))
				{
					$errors['uemail'] = 'Confirmation email does not match';
				}
				else
				{
					$query = "
						SELECT user_id
						FROM users
						WHERE user_email = ?
					";

					$result = $this->db->query($query, array($this->vars['uemail']));

					if ($result->num_rows())
					{
						$errors['uemail'] = 'This email is already in use';
					}
				}



				$this->vars['upassword'] = trim($_POST['user_info']['user_password']);
				if (strlen($this->vars['upassword']) < 6)
				{
					$errors['upassword'] = 'Your password cannot be less than 6 characters or blank';
				}
				else if ($this->vars['upassword'] != trim($_POST['check_parent_password']))
				{
					$errors['upassword'] = 'Confirm password does not match';
				}


				$this->vars['phone'] = trim($_POST['user_info']['user_phone']);
				if (strlen($this->vars['phone']) == 0)
				{
					$errors['phone'] = 'Your phone number cannot be blank';
				}

				if (isset($_POST['comm_info']['newsletter']))
				{
					$this->vars['newsletter'] = 1;
				}

				if (isset($_POST['comm_info']['allowance_reminder']))
				{
					$this->vars['alreminder'] = 1;
				}

				if (isset($_POST['comm_info']['quarterly_reminder']))
				{
					$this->vars['qreminder'] = 1;
				}

				if (isset($_POST['comm_info']['allowance_status']))
				{
					$this->vars['alstatus'] = 1;
				}

			}
			
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

			$this->vars['cusername'] = trim($_POST['child_info']['user_name']);
			if (strlen($this->vars['cusername']) < 6)
			{
				$errors['cusername'] = "Your child's username cannot be less than 6 characters or blank";
			}
			else
			{
				$query = "
					SELECT user_id
					FROM users
					WHERE user_name = ?
				";

				$result = $this->db->query($query, array($this->vars['cusername']));

				if ($result->num_rows())
				{
					$errors['cusername'] = "Your child's username is already in use";
				}
			}

			$this->vars['cpassword'] = trim($_POST['child_info']['user_password']);
			if (strlen($this->vars['cpassword']) < 6)
			{
				$errors['cpassword'] = "Your child's password cannot be less than 6 characters or blank";
			}
			else if ($this->vars['cpassword'] != trim($_POST['check_child_password']))
			{
				$errors['cpassword'] = "Your child's confirm password does not match";
			}

			$this->vars['birthday'] = trim($_POST['child_info']['birthday']);
			if (strlen($this->vars['birthday']) == 0)
			{
				$errors['birthday'] = "Your child's birthday cannot be blank";
			}

			$this->vars['gender'] = trim($_POST['child_info']['gender']);
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

			$this->vars['paidon'] = trim($_POST['child_info']['allowance_payday']);
			if ($this->vars['paidon'] == '-')
			{
				$errors['paidon'] = "Your child's pay day cannot be blank";
			}

			$this->vars['init_deposit'] = trim($_POST['init_deposit']);
			if (strlen($this->vars['init_deposit']) == 0)
			{
				$errors['init_deposit'] = "Your initial deposit cannot be blank";
			}
			else if ($this->vars['init_deposit'] < 0)
			{
				$errors['init_deposit'] = "Your initial deposit cannot be a negative value";
			}
			else if (!is_numeric($this->vars['init_deposit']))
			{
				$errors['init_deposit'] = "Your initial deposit must be a number";
			}

			$this->vars['freq'] = trim($_POST['child_info']['allowance_frequency']);
			if ($this->vars['freq'] == '-')
			{
				$errors['freq'] = "Your child's allowace frequency cannot be blank";
			}

			if (count($errors))
			{
				$this->vars['error_vars'] = $errors;
				set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger', $errors);
			}
			else
			{
				$this->session->set_userdata('signup_data', $this->vars);
				header('Location: /new/signup/step3');
				//echo "success";
				exit;
			}

		}


		$this->data['pagebody']  	= 'v2/signup2';
		$this->data['pagetitle'] 	= 'Signup ';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Signup with dragon bank today. Use access code and begin your childs spend, save, give money.';
		
		//$data['addJS'] = "jquery.validate.min.js, validateForm.js";
		$this->load->vars($this->vars);
		
		$this->render();
	}

	public function step3()
	{
		if (!$this->session->userdata('access_code') || !$this->session->userdata('signup_data'))
		{
			header('Location: /new/signup');
			exit;
		}

		$this->vars = array(
			'allocation' => 1,
			'spend' => 0,
			'save' => 0,
			'give' => 0
		);

		if (isset($_POST['activate_step3']))
		{
			$errors = array();


			$this->vars['allocation'] = $_POST['allocation'];

			if ($_POST['allocation'] == 1)
			{
				$this->vars['spend'] = trim($_POST['spend1']);
				$this->vars['save'] = trim($_POST['save1']);
				$this->vars['give'] = trim($_POST['give1']);
			}
			else if ($_POST['allocation'] == 2)
			{
				$this->vars['spend'] = trim($_POST['spend2']);
				$this->vars['save'] = trim($_POST['save2']);
				$this->vars['give'] = trim($_POST['give2']);
			}
			else if ($_POST['allocation'] == 3)
			{
				$this->vars['spend'] = trim($_POST['spend3']);
				$this->vars['save'] = trim($_POST['save3']);
				$this->vars['give'] = trim($_POST['give3']);
			}
			else if ($_POST['allocation'] == 4)
			{
				$this->vars['spend'] = trim($_POST['spend4']);
				if ($this->vars['spend'] < 0)
				{
					$errors['spend'] = 'Spend cannot be a negative value';
				}
				else if (!is_numeric($this->vars['spend']))
				{
					$errors['spend'] = 'Spend must be a number';
				}


				$this->vars['save'] = trim($_POST['save4']);
				if ($this->vars['save'] < 0)
				{
					$errors['save'] = 'Save cannot be a negative value';
				}
				else if (!is_numeric($this->vars['save']))
				{
					$errors['save'] = 'Save must be a number';
				}

				$this->vars['give'] = trim($_POST['give4']);
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
				/*
				$this->vars = array(			
					'ufirst' 		=> "",
					'ulast'         => "",
					'uemail' 		=> "",
					'upassword'		=> '',
					'phone' 		=> "",
					'newsletter' => '',
					'alreminder' => '',
					'qreminder' => '',
					'alstatus' => '',
					'cfirst' 		=> "",
					'clast'         => "",
					'cusername' 	=> "",
					'cpassword'		=> '',
					'birthday' 		=> "",
					'gender' 		=> "",
					'allowance' 	=> '',
					'paidon' 		=> "1",
					'init_deposit' 	=> "",
					//'kids' 			=> "",
					'ucemail' 		=> "",
					'freq'			=> "",
					//'code'	=> $this->session->userdata('access_code')
				);
				*/

				$signup_data = $this->session->userdata('signup_data');

				// if new parent
				if (!empty($signup_data['ufirst']))
				{
					// create user record for parent
					$user = array(
						'user_full_name' => $signup_data['ufirst'] . ' ' . $signup_data['ulast'],
						'user_email' => $signup_data['uemail'],
						'user_password' => md5($signup_data['upassword']),
						'user_group' => 2,
						'registration_date' => date('Y-m-d'),
						'user_phone' => $signup_data['phone'],
						'status' => 1
					);

					$this->db->insert('users', $user);

					$userID = $this->db->insert_id();

					// create parent record
					$parent = array(
						'parent_user_id' => $userID,
						'kids' => 1,
						'active_kids' => 1,
						'status' => 1,
						'allowance_reminder' => $signup_data['alreminder'],
						'dragon_newsletter' => $signup_data['newsletter'],
						'quarterly_reminder' => $signup_data['qreminder'],
						'allowance_status' => $signup_data['alstatus']
					);

					if ($this->session->userdata('advisor_id'))
					{
						$parent['advisor_id'] = $this->session->userdata('advisor_id');
					}

					$this->db->insert('parents', $parent);

					$parentID = $this->db->insert_id();
				}

				// if the parent didnt exist during creation, it means the user logged in is the parent
				if (!isset($parentID))
				{
					$parentID = $this->session->userdata('type_id');
				}

				// create user record for child
				$user = array(
					'user_full_name' => $signup_data['cfirst'] . ' ' . $signup_data['clast'],
					'user_name' => $signup_data['cusername'],
					'user_password' => md5($signup_data['cpassword']),
					'user_group' => 3,
					'registration_date' => date('Y-m-d'),
					'status' => 1
				);

				$this->db->insert('users', $user);
				$userID = $this->db->insert_id();

				$spend_amount = $signup_data['init_deposit'] * $this->vars['spend'] * 0.01;
				$save_amount = $signup_data['init_deposit'] * $this->vars['save'] * 0.01;
				$give_amount = $signup_data['init_deposit'] * $this->vars['give'] * 0.01;

				// create child record
				$child = array(
					'child_user_id' => $userID,
					'parent_id' => $parentID,
					'gender' => $signup_data['gender'],
					'birthday' => $signup_data['birthday'],
					'allowance' => $signup_data['allowance'],
					'balance' => $signup_data['init_deposit'],
					'spend' => $this->vars['spend'],
					'spend_amount' => $spend_amount,
					'save' => $this->vars['save'],
					'save_amount' => $save_amount,
					'give' => $this->vars['give'],
					'give_amount' => $give_amount,
					'profile_image' => 'default.png',
					'status' => 1,
					'allowance_frequency' => $signup_data['freq'],
					'allowance_payday' => $signup_data['paidon'],
					'allocation_type' => $this->vars['allocation'],
					'code_id' => $signup_data['code_id']
				);

				$this->db->insert('children', $child);
				$childID = $this->db->insert_id();

				// bullshit Ron function.
				if ($signup_data['init_deposit'] > 0)
				{
					$this->saveHistory($signup_data['init_deposit'], $spend_amount, $save_amount, $give_amount, $childID);
				}

				// bullshit Ron function.
				$this->setPaydate($childID, $signup_data['freq'], $signup_data['paidon']);

				// disable code

				$query = "
					UPDATE codes
					SET status = 0
					WHERE codename = '" . $this->session->userdata('access_code') . "'";

				$this->db->query($query);


				$sex1 = "she";
				$sex2 = "her";
				$freq = "weekly";

				if (strtolower($child['gender']) == "male")
				{
					$sex1 = "he";
					$sex2 = "his";
				}
			
				if ($child['allowance_frequency'] == "MONTH")
				{
					$freq = "monthly";
				}

				// mailchimp
				if (!$this->session->userdata('type_id'))
				{
					$this->load->helper('mailchimp');
					
					$drsub = array(
						'id' => mailchimp_list_id("dragon"),
						'email' => array('email' => $signup_data['uemail']),
						'merge_vars' => array('FNAME' => $signup_data['ufirst'] . ' ' . $signup_data['ulast']),
						'replace_interests' => false,
					);

					if (isset($signup_data['newsletter']) && $signup_data['newsletter'] > 0)
					{
						// Dragon newsletter.
						$id = mailchimp_subscribe($drsub);
						
						// Updates parents class with dragon newsletter email id.
						$this->parentsclass->updateWhere(array("dragon_newsletter" => $id), "parent_id", $parentID);
					}
				}
				

				// do email with ron's shit
				if (!$this->session->userdata('type_id'))
				{
	
					$info = array(
						"name" 	=> $signup_data['ufirst'] . ' ' . $signup_data['ulast'],
						"email"	=> $signup_data['uemail'],
						"ppass"	=> $signup_data['upassword'],
						"cpass"	=> $signup_data['cpassword'],
						"cuser"	=> $signup_data['cusername'],
						"cname" => $signup_data['cfirst'] . ' ' . $signup_data['clast'],
						"spa"	=> $spend_amount,
						"saa"	=> $save_amount,
						"gia"	=> $give_amount,
						"total"	=> $signup_data['init_deposit'],
						"sex1"	=> $sex1,
						"sex2"	=> $sex2,
						"freq"  => $freq
					);
					
					// Sends welcome email.
					sendNotification("Your Dragon Bank Is Active!", welcomeMsg($info, $this->session->userdata('advisor_id')), $info['email']);
				}
				else
				{
					$info = array(
						"email"	=> $this->session->userdata('name_email'),
						"cpass"	=> $signup_data['cpassword'],
						"cuser"	=> $signup_data['cusername'],
						"cname" => $signup_data['cfirst'] . ' ' . $signup_data['clast'],
						"spa"	=> $spend_amount,
						"saa"	=> $save_amount,
						"gia"	=> $give_amount,
						"total"	=> $signup_data['init_deposit'],
						"sex1"	=> $sex1,
						"sex2"	=> $sex2,
						"freq"  => $freq
					);
					sendNotification("Your Dragon Bank Is Active!", welcomeMsgChild($info, $this->session->userdata('advisor_id')), $info['email']);

				}

				header('Location: /new/success');
				exit;
			}
		}


		

		$this->data['pagebody']  	= 'v2/signup3';
		$this->data['pagetitle'] 	= 'Signup ';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Signup with dragon bank today. Use access code and begin your childs spend, save, give money.';
		
		$data['addJS'] = "allocations.js";

		$this->load->vars($this->vars);
		$this->load->vars($this->session->userdata('signup_data'));
		$this->load->vars($data);
		
		$this->render();
	}


	// bullshit Ron function.
	private function setPaydate( $cid, $frequency, $d )
	{
		$this->load->model('childrenclass');

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


	// bs Ron function.
	private function saveHistory($total, $sp, $sa, $gi, $cid)
	{
		$this->load->model('childrenclass');
		$rec 	 = array();
		$account = $this->childrenclass->getAccounts( $cid );
		
		$rec['date'] 				= date("Y-m-d");
		$rec['history_child_id'] 	= $cid;
		$rec['balance']				= $this->childrenclass->getBalance( $cid );
		$rec['spend_history']		= $sp;
		$rec['save_history']		= $sa;
		$rec['give_history']		= $gi;
		$rec['spend_balance']		= (double)$account->spend_amount;
		$rec['save_balance']		= (double)$account->save_amount;
		$rec['give_balance']		= (double)$account->give_amount;
		$rec['desc'] 				= "Signup initial deposit";
		
		$rec['credit'] 		= (float)$total;
		$rec['transaction']	= "Deposit"; 
		
		save_or_update("historyclass", "history_id", "", $rec);
	}




}

/* End of file signup.php */
/* Location: ./application/controllers/signup.php */
