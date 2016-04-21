<?php
/**
 * signup3.php Controller Class.
 */
class Signup3 extends Application {
	
    function __construct(){
        parent::__construct();
		$this->load->model( array('codesclass', 'parentsclass') );
    }
	
	function validateAndSave()
	{
		$spend 	= 0;
		$save 	= 0;
		$give 	= 0;
		$select = 0;
		
		if( isset( $_POST['allocation'] ) )
		{
			$select = $_POST['allocation'];
			$spend	= $_POST['spend'. $select];
			$save	= $_POST['save'	. $select];
			$give	= $_POST['give'	. $select];

		}
		
		$total = number_format( ($spend + $save + $give), 2 );
		
		// The value amount equals 100.00, so continue to finish sign up process.
		if( (float)$total == 100.00 )
		{
			$p = $this->session->userdata('parent_info');
			$c = $this->session->userdata('child_info');
			
			// We are now auto generating the child's username and password.
			$pass = random_string(10, 3);
			$user = $this->generateUsername( str_replace( " ", "", $c['user_full_name'] ) );
			echo ($user);
			die;
			// Sets status to inactive.
			$this->setCodeStatus();
			
			// Save parent.
			$parent_id = $this->saveParent();
			
			$sp 	= 0.00; // Spend amount.
			$sa 	= 0.00; // Save amount.
			$gi 	= 0.00; // Give amount.
			$total  = 0.00; // Total amount.
			
			if( isset( $_POST['init_deposit'] ) && (float)$_POST['init_deposit'] > 0 )
			{
				$dep = (float)$_POST['init_deposit'] * 0.01;
				
				$sp 	= $dep * $spend;
				$sa 	= $dep * $save;
				$gi 	= $dep * $give;
				$total	= (float)($sp + $sa + $gi );
			}
			
			if( strtolower($c['gender']) == "male" )
			{
				$sex1 = "he";
				$sex2 = "his";
			}
			else
			{
				$sex1 = "she";
				$sex2 = "her";
			}

            if( $c['allowance_frequency'] == "MONTH" )
            {
                $freq = "monthly";
            }
            else
            {
                $freq = "weekly";
            }
			
			// Save child
			$this->saveChild($parent_id, $spend, $save, $give, $select, $user, $pass );
			
			$info = array(
				"name" 	=> $p['user_first_name'],
				"email"	=> $p['user_email'],
				"ppass"	=> $p['user_password'],
				"cpass"	=> $pass,
				"cuser"	=> $user,
				"cname" => $c['user_first_name'],
				"spa"	=> $sp,
				"saa"	=> $sa,
				"gia"	=> $gi,
				"total"	=> $total,
				"sex1"	=> $sex1,
				"sex2"	=> $sex2,
                "freq"  => $freq
			);
			
			// Sends welcome email.
			sendNotification("Your Dragon Bank Is Active!", welcomeMsg( $info ), $info['email'] );

			// Signup to newsletters only if parent is a new member. 
			if( ! isset( $this->sud->type_id ) )
			{
				$this->load->helper('mailchimp');
				
				$drsub = array(
					'id'                => mailchimp_list_id("dragon"),
					'email'             => array('email' => $p['user_email']),
					'merge_vars'        => array('FNAME' => $p['user_full_name']),
					'replace_interests' => false,
				);

				if( isset( $c['drsub'] ) && (int)$c['drsub'] > 0  )
				{
					// Dragon newsletter.
					$id = mailchimp_subscribe( $drsub );
					
					// Updates parents class with dragon newsletter email id.
					$this->parentsclass->updateWhere( array("dragon_newsletter" => $id), "parent_id", $parent_id );
				}
			}

			// Unset useless signup session data.
			$this->session->unset_userdata( array(
				"signup2" 		=> '',
				"access_code" 	=> '',
				"parent_info" 	=> '', 
				"child_info" 	=> ''
			) );
			
			flash_redirect("success");
		}
		else
		{
			flash_redirect("signup3", status('', "Allocation must equal 100.00<br/>custom allocation equaled: $total", "red"), "flash");
		}
	}
	
	private function setCodeStatus()
	{
		$code 		= $this->session->userdata("access_code");	
		$code_id 	= $this->codesclass->getCodeIdByName( $code );
		
		$this->codesclass->update( array('id' => $code_id, 'status' => 0) );
		
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
	
	private function saveParent()
	{
		$user_id 	= 0;
		$parent_id 	= 0;
		
		// Set parent's info.
		$rec = $this->session->userdata('parent_info');
		
		if( $this->session->userdata('user_id') )
		{
			$user_id = $rec['user_id'] = (int)$this->session->userdata('user_id');
		}
		
		$rec['user_full_name'] 		= trim($rec['user_full_name']);
		
		if( ! isset( $this->sud->user_id ) )
		{
			$rec['registration_date'] 	= date("Y-m-d");
		}
		
		$rec['user_group']			= 2;
		
		if( isset( $rec['user_password'] ) )
		{
			if( ! isset( $this->sud->parent_id ) || ( $this->sud->parent_id > 0 && strlen( $rec['user_password'] ) > 0 ) )
			{
				$rec['user_password'] = md5($rec['user_password']);
			}
			else
			{
				unset( $rec['user_password'] ); // We do not want to change the parent's password if it was not set.
			}
		}
		

		// Save user.
		$user_id = save_or_update('usersclass', 'user_id', 'Parent', set_record('user', $rec));
		
		if( ! $user_id )
		{
			flash_redirect("signup", status('', "<span style='width: 585px;
			float: right;'>User Account Creation Failed</span>", "red"), "flash");
		}
		
		$rec['parent_user_id'] = $user_id;
		
		if( $this->session->userdata('type_id') )
		{
			$parent_id = $rec['parent_id'] = (int)$this->session->userdata('type_id');
		}
	
		// Save parent.

		if ($this->session->userdata('advisor_id'))
		{
			$rec['advisor_id'] = $this->session->userdata('advisor_id');
		}

		$parent_id = save_or_update('parentsclass', 'parent_id', 'Parent', set_record('parents', $rec));
		
		if( ! $parent_id )
		{
			flash_redirect("signup", status('', "<span style='width: 585px;
			float: right;'>Parent Account Creation Failed</span>", "red"), "flash");
		}
		
		// Incremenets active_kids by one.
		$this->parentsclass->update( array('parent_id' => $parent_id), 'active_kids', 'active_kids+1');
		
		return $parent_id;
	}

	
	private function saveHistory( $total, $sp, $sa, $gi, $cid )
	{
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
	
	private function saveChild( $parent_id, $spend, $save, $give, $allocation, $user, $pass )
	{	
	
		$sp_amount = 0.00; // Spend amount.
		$sa_amount = 0.00; // Save amount.
		$gi_amount = 0.00; // Give amount.
		$total	   = 0.00; // Total amount.
		
		// Set parent's child info.
		$rec 	= $this->session->userdata('child_info');
		$time 	= date("Y-m-d");

		$rec['registration_date'] 	= $time;
		$rec['user_group']			= 3;
		$rec['user_full_name']		= trim( $rec['user_full_name'] );
		$rec['allocation_type']		= $allocation;
		$rec['user_password'] 		= md5($pass);
		$rec['user_name']			= $user;
		
		// Save user.
		$user_id = save_or_update('usersclass', 'user_id', 'Child', set_record('user', $rec));
		
		if( ! $user_id )
		{
			flash_redirect("signup", status('', "<span style='width: 585px;
			float: right;'>User Account Creation Failed</span>", "red"), "flash");
		}
		
		if( isset( $_POST['init_deposit'] ) && (float)$_POST['init_deposit'] > 0 )
		{
			$dep = (float)$_POST['init_deposit'] * 0.01;
			
			$sp_amount = $dep * $spend;
			$sa_amount = $dep * $save;
			$gi_amount = $dep * $give;
		}
		
		$rec['child_user_id'] 	= $user_id;
		$rec['parent_id'] 		= $parent_id;
		$rec['spend'] 			= $spend;
		$rec['spend_amount']	= $sp_amount;
		$rec['save'] 			= $save;
		$rec['save_amount']		= $sa_amount;
		$rec['give'] 			= $give;
		$rec['give_amount']		= $gi_amount;
		
		$total = (float)( $sp_amount + $sa_amount + $gi_amount );
		
		$rec['balance']	= $total;
		
		// Save child.
		$child_id = save_or_update('childrenclass', 'child_id', 'Child', set_record('children', $rec));
		
		// Only save history if there was an initial deposit.
		if( (float)$total > 0.00 )
		{
			$this->saveHistory($total, $sp_amount, $sa_amount, $gi_amount, $child_id );
		}

		// Set payday, if allowance was set
		if( isset( $_POST['init_deposit'] ) && (float)$_POST['init_deposit'] > 0.00 )
		{
			$this->setPaydate($child_id, $rec['allowance_frequency'], (int)$rec['allowance_payday']);
		}
		
		return;
	}
    
    function index(){
		
		$cc = $this->codesclass;
		
		// Validates signup2 page post submit.
		// Important as without it, you could sign up with JavaScript disabled.
		if( ! $this->session->userdata('access_code') || ! $this->session->userdata('signup2') )
		{
			flash_redirect("signup", status('', "<span style='width: 585px;
			float: right;'>Please use a valid access code</span>", "red"), "flash");
		}
		
		if( $this->session->userdata("init_deposit") && ( (int)$this->session->userdata("init_deposit") ) > 0 )
		{
			$data['init_deposit'] = (int)$this->session->userdata("init_deposit");
		}
		
		if( $this->reqType( "POST" ) )
		{	
			/**
			 * This function saves both parent and child.
			 * It also sends a welcome email and subscribes the email address to a newsletter
			 * from a 3rd party a.k.a MailChimp.
			 * Finally, it redirects on success or failure.
			 */
			$this->validateAndSave();
		}
        $this->data['pagebody']  = 'v2/signup3';
        $this->data['pagetitle'] = 'Dragon Bank | Signup3 ';

		$data['addJS'] = "allocations.js";

		$this->load->vars($data);

        $this->render();
		
    }
}

/* End of file signup3.php */
/* Location: ./application/controllers/signup3.php */