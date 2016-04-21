<?php
class Webservice
{
	var $con1 = false;
	var $con2 = false;
	var $db1='dragonbank_new';
	var $db2=''; 
	
	
	/***************************** database connectivity   ***************************/
	function __construct (){
		header('Content-type: application/json');
		//include('function.php');
		$this->con1=mysql_connect('localhost','dragonuser','FOeEptsSfE5y') or die('Cannot connect to the DB');
		if($this->con1){
			mysql_select_db($this->db1,$this->con1) or die('Cannot select the DB');
		}else{
			echo "connection not established";
		}
		if(isset($_REQUEST['apps_id'])){
			$this->getAppDB($_REQUEST['key']);
		}else{
			if(isset($_SESSION['appDBconnection'])){
				$this->con2= $_SESSION['appDBconnection'];
				$this->db2= $_SESSION['appDB'];
			}
		}
	}
	
	function accesscode_varify(){
	
	  if($_REQUEST['code'])
        {
       		$sql="select * from codes where `codename` = '".$_REQUEST['code']."'"; 
			$page_rs = mysql_query($sql);
		    $page_num = mysql_num_rows($page_rs);
			if($page_num == 0){ 
				$post="Oops. The code you entered is invalid. Please try again!";
				$posts = array('success'=>'0','msg'=>$post);
			}else{
				$result=array();
		  	    while($row[] = mysql_fetch_assoc($page_rs));
		  	    $result = array_filter($row);
		  	    $result = array_filter($result[0]);
		  	    if(isset($result['status']) && $result['status'] == (int)1){
		   			$post="Code is valid";
		   			$posts = array('success'=>'1','msg'=>$post,'result'=>$result);
		   		}else{
		   			$post="Oops! That activation code is already in use. Please try again or contact support for assistance!";
		   			$posts = array('success'=>'0','msg'=>$post);
		   		}
		   	}
		  
		}
		echo json_encode($posts);
  	}

   function step2(){     		
     	     if(isset($_REQUEST['Email'])){
					$sql = "Select * FROM `users` WHERE `user_email`='".$_REQUEST['Email']."' AND `status`=1";      	     
					$rs = mysql_query($sql);
					$num = mysql_num_rows($rs);
		       if($num == 0){
     	        if($_REQUEST['firstname'] && $_REQUEST['lastname'] && $_REQUEST['Email'] && $_REQUEST['password'])
     	         {
                	$fullname= $_REQUEST['firstname']. ' ' .$_REQUEST['lastname'];
					$user_email = $_REQUEST['Email'];
					$user_password = md5($_REQUEST['password']);
					$registration_date = date('Y-m-d');
                	$sql2 = "INSERT INTO `users` (`user_full_name`,`user_email`,`user_password`,`user_group`,`registration_date`,`user_phone`,`status`) values ('".$fullname."','".$user_email."','".$user_password."','2','".$registration_date."','".$_REQUEST['phone_number']."','1')";
			        mysql_query($sql2);
			        $userid=mysql_insert_id();    
			       
                   $post="First steps is completed.";
				   $posts = array('success'=>'1','msg'=>$post,'userid'=>$userid);
                }
			}else{
				$post="Oops! That email is already taken!";
				$posts = array('success'=>'0','msg'=>$post);
			}
			
		}echo json_encode($posts);
	}


     function step3(){
         if($_REQUEST['codeid'] && $_REQUEST['userid'] && $_REQUEST['cfirstname'] && $_REQUEST['clastname'] && $_REQUEST['cusername'] && $_REQUEST['cpassword'] && $_REQUEST['alamount'] && $_REQUEST['alfrequency'] && $_REQUEST['paydate'] && $_REQUEST['initial_deposit'])
         {
			$sql = "Select `user_email`,`user_full_name` FROM `users` WHERE `user_id`='".$_REQUEST['userid']."'"; 			
			$result=$this->getsqlResult($sql);
			$cfullname= $_REQUEST['cfirstname']. ' ' .$_REQUEST['clastname'];
			$cuser_name = $_REQUEST['cusername'];
			$parent_user_id = $_REQUEST['userid'];
			$birthday = date('Y-m-d',strtotime($_REQUEST['birthday']));
			$cuser_password = md5($_REQUEST['cpassword']);
			$registration_date = date('Y-m-d');
			$sql2 = "INSERT INTO `users` (`user_full_name`,`user_name`,`user_password`,`user_group`,`registration_date`,`status`) values ('".$cfullname."','".$cuser_name."','".$cuser_password."','3','".$registration_date."','1')";
			$res = mysql_query($sql2);
			$childuserid=mysql_insert_id();	
				if($res){
					$sql2 = "INSERT INTO `parents` (`parent_user_id`,`kids`,`active_kids`,`status`) values ('".$parent_user_id."','1','1','1')";
					mysql_query($sql2);
					$parentID = mysql_insert_id();	
					if($_REQUEST['alfrequency']=='none'){			      
					$sql3 = "INSERT INTO `children` (`child_user_id`,`parent_id`,`birthday`,`allowance`,`balance`,`profile_image`,`status`,`allowance_frequency`,`allowance_payday`,`code_id`) values ('".$childuserid."','".$parentID."','".$birthday."','".$_REQUEST['alamount']."','".$_REQUEST['initial_deposit']."', 'default.png','1','0','". $_REQUEST['paydate']."','".$_REQUEST['codeid']."')";
					}else{
					$sql3 = "INSERT INTO `children` (`child_user_id`,`parent_id`,`birthday`,`allowance`,`balance`,`profile_image`,`status`,`allowance_frequency`,`allowance_payday`,`code_id`) values ('".$childuserid."','".$parentID."','".$birthday."','".$_REQUEST['alamount']."','".$_REQUEST['initial_deposit']."', 'default.png','1','".$_REQUEST['alfrequency']."','". $_REQUEST['paydate']."','".$_REQUEST['codeid']."')";
					}
					mysql_query($sql3);			
					$childid=mysql_insert_id();
					$sq = "Select `child_user_id` FROM `children` WHERE `child_id`='".$childid."'"; 			
					$results=$this->getsqlResult($sq);
					$sql4 = "Select `user_name` FROM `users` WHERE `user_id`='".$results['child_user_id']."'"; 			
					$res=$this->getsqlResult($sql4);
					$post="Third steps is completed. ";	
					$message = 'Dear <b>'.ucfirst($result['user_full_name']).'</b>,<br><br>We received your registration details for your <b></b>"'.ucfirst($res['user_name']).'"<br><br>'.'If you need any assistance, we are happy to help. Just drop us an email at   support@dragonbank.com.<br><br> Thanks again for using Dragon Bank!'.'<br><br>'.'Sincerely,<br>';
					//$message .= 'Thanks and Regards,<br>';
					$message .= 'Dragon bank Support team <br>';
					$message .= 'Email: support@dragonbank.com <br>';
					$message .= 'Web: www.dragonbank.com';
					$this->emailHelper($result['user_email'],'Child Registration Confirmation'  ,$message);			
					$posts = array('success'=>'1','msg'=>$post,'initial_deposit'=>$_REQUEST['initial_deposit'],'childid'=>$childid);
				}else{
					$posts = array('success'=>'0','msg'=>'Username'.' '.$cuser_name.'Already exists.');
				}
			}else{			
				$posts = array('success'=>'0','msg'=>'Error');
		 }
         echo json_encode($posts);
     }

       function chooseden_allocationtype(){
                
               if(isset($_REQUEST['allocation_type']) && isset( $_REQUEST['code_id']) && isset($_REQUEST['parentid']) && isset($_REQUEST['initial_deposit']) && isset($_REQUEST['childid']) && isset($_REQUEST['spend']) && isset($_REQUEST['save']) && isset($_REQUEST['give']))
				{
					switch ($_REQUEST['allocation_type']) {
						case 1:
							$spend= 80;
							$save= 10;
							$give1 = 10;	
							break;
						case 2:
							$spend = 40;
							$save = 50;
							$give1 = 10;
							break;
						case 3:
							$spend = 33.4;
							$save = 33.3;
							$give1 = 33.3;
							break;
						case 4:
							if($_REQUEST['spend'] && $_REQUEST['save'] && $_REQUEST['give']){
								$spend = trim($_REQUEST['spend']);
								if ($spend < 0){
									$errors['spend'] = 'Spend cannot be a negative value';
								}elseif(!is_numeric($spend)){
									$errors['spend'] = 'Spend must be a number';
								}
								$save = trim($_REQUEST['save']);
								if ($save < 0){
									$errors['save'] = 'Save cannot be a negative value';
								}elseif (!is_numeric($save)){
									$errors['save'] = 'Save must be a number';
								}
								$give1 = trim($_REQUEST['give']);
								if ($give1 < 0){
									$errors['give'] = 'Give cannot be a negative value';
								}elseif (!is_numeric($give1)){
									$errors['give'] = 'Give must be a number';
								}
								if (is_numeric($spend) && is_numeric($save) && is_numeric($give1) &&($spend + $save + $give1 != 100)){
									$errors['total'] = 'Spend, save, and give must equal 100%';
								}
							  }								
							break;
					} 
					$spend_amount = $_REQUEST['initial_deposit'] * $spend * 0.01;
					$save_amount = $_REQUEST['initial_deposit'] * $save * 0.01;
					$give_amount = $_REQUEST['initial_deposit'] * $give1 * 0.01;																																																																																							                     
					$sql2 = "UPDATE `children` SET `spend`= '".$spend."',`spend_amount`='".$spend_amount."',`save`='".$save."',`save_amount`='".$save_amount."',`give`='".$give1."',`give_amount`='".$give_amount."',`allocation_type`='".$_REQUEST['allocation_type']."' WHERE child_id='".$_REQUEST['childid']."'";
					mysql_query($sql2);
					$sql2 = "UPDATE `codes` SET `status`= '0' WHERE id='".$_REQUEST['code_id']."'";
					mysql_query($sql2);
					$this->saveHistory( (float)$_REQUEST['initial_deposit'], $spend_amount, $save_amount, $give_amount, $_REQUEST['childid'], $desc='Signup initial deposit','Deposit');
					$post="Registered Successfully ";
					$posts = array('success'=>'1','msg'=>$post);
			}else{			
				$posts = array('success'=>'0','msg'=>'Error');
			}
			echo json_encode($posts);
		}

		function login(){
			
     	     if(isset($_REQUEST['username']) && isset($_REQUEST['password'])){
				$user_name= $_REQUEST['username'];
				$password = $_REQUEST['password'];			
				$sql = "Select * FROM `users` WHERE `user_name`='".$user_name."' OR `user_email`='".$user_name."'"; 			
				$rs=mysql_query($sql);			  		  
				$num = mysql_num_rows($rs);					
				if($num != NULL && $num > 0){
					$row = mysql_fetch_assoc($rs);
					extract($row);							
					if ($user_group == 1){
						$name_email = $user_email;
					}			
				   	if($user_group==2 ){
				  		$sql = "SELECT `parent_id` FROM (`parents`) WHERE `parent_user_id` =  $user_id ORDER BY `parent_id` asc";
				  		$parent = $this->getsqlResult($sql);					  		
				  		$typeID = $parent['parent_id'];				  		
				   		$user_email=$user_email;
				   	}
				   	if($user_group==3){
			   		 	$sql = "SELECT `children`.*, `uc`.`user_full_name`, `up`.`user_full_name` parentname, `up`.`user_email`, `parents`.`advisor_id` FROM (`children`) JOIN `users` uc ON `uc`.`user_id` = `children`.`child_user_id` JOIN `parents` ON `parents`.`parent_id` = `children`.`parent_id` JOIN `users` up ON `up`.`user_id` = `parents`.`parent_user_id` WHERE `uc`.`user_id` = $user_id AND `children`.`status` = 1 ORDER BY `up`.`user_full_name` ASC, `uc`.`user_full_name` ASC";
			  			$child = $this->getsqlResult($sql);				  			
			  			$typeID = $child['child_id'];
						$user_email=$user_name;
				   	}
				   	if($user_group==5){
				   		$sql = "SELECT `advisors`.*, `provinces`.`code` province_code FROM (`advisors`) LEFT JOIN `provinces` ON `provinces`.`id` = `advisors`.`province_id` WHERE `advisors`.`user_id` = '1844'";
				   		$advisor = $this->getsqlResult($sql);				  			
			  			$typeID = $advisor['id'];
				   		$user_email=$user_email;
				   	}				   		

				   		$data = array(
								'user_id'       => $user_id,
								'logged_in' 	=> TRUE, 
								'user_group'	=> $user_group, 
								'user_name'		=> $user_full_name,
								'initiated' 	=> TRUE,
								'name_email' 	=> $user_email,
								'user_status'	=> $status,
								'type_id'		=> $typeID,
								'phone'         => $user_phone							
								);							
					if (md5($password) != $user_password){
						$msg="Incorrect Username or Password.";
						$posts = array('success'=>'0','msg'=>$msg);
					}else{
						$msg="Login successfull";
						$posts = array('success'=>'1','msg'=>$msg,'data'=>$data);
					}
						
						
					if ($status != 1 && $user_group == 2){
						$msg = "Your account has been suspended. Please contact Dragon Bank support for further details.";
						$posts = array('success'=>'0','msg'=>$msg);
					}
					if ($status != 1 && $user_group == 3 ){
						$msg = "Uh Oh! Your account has changed. Please ask your parents to log into their account for more information.";
						$posts = array('success'=>'0','msg'=>$msg);
					}
					
					$sql = "Select site_status FROM `settings` WHERE `settings_id`=1";				
					$row = $this->getsqlResult($sql);
					
					if($row['site_status'] === 0 && $result[0]['user_group'] != 1 )
					{
						$msg = "Site is under construction. Please try again later.";
						$posts = array('success'=>'0','msg'=>$msg);
					}	
				
				}else{
					$msg="Incorrect username/email";
					$posts = array('success'=>'0','msg'=>$msg);
			    }
			}else{			
				$posts = array('success'=>'0','msg'=>'Error');
			}			
		     echo json_encode($posts);
		}
	 	function wishlist()
	 	{
			if(isset($_REQUEST['childid'])){
				$childid= $_REQUEST['childid'];
				$sql = "Select * FROM `wishlist` WHERE `child_id`='".$childid."' ";				
				$rs=mysql_query($sql);
				$num = mysql_num_rows($rs);
				$sql = "Select `children`.spend_amount FROM  `children` WHERE `child_id` = '".$childid."'";		
				$spend_amount =  $this->getsqlResult($sql);	
				if($num>0){						
					while(($data[] = mysql_fetch_assoc($rs)) || array_pop($data)); 	
					foreach($data as $k=>$v):
						$data[$k]['date'] = date('Y-m-d',$v['date']);
					endforeach;				
					$posts = array('success'=>'1','msg'=>'Wishlist record found','result'=>$data,'spend_amount'=>$spend_amount['spend_amount']);	
				}else{
					$posts = array('success'=>'0','msg'=>'No record found','spend_amount'=>$spend_amount['spend_amount']);
				}
			}else{			
				$posts = array('success'=>'0','msg'=>'Error');
			}
			echo json_encode($posts);
	   }
	   
	 	function history_search()
	 	{
			if(isset($_REQUEST['childid']) &&isset($_REQUEST['day']) && isset($_REQUEST['month']) && isset($_REQUEST['year'])){
				$childid= $_REQUEST['childid'];				
				$year  = strtolower($_REQUEST['year']);
				$month  = strtolower($_REQUEST['month']);
				$day  = strtolower($_REQUEST['day']);
				if($year == 'all') $year = '____';
				if($month == 'all') $month = '__';				
				if($day == 'all') $day = '__';				
				$sql = "SELECT * FROM `history` WHERE date LIKE '".$year."_".$month."_".$day."' AND	`history_child_id` = $childid ORDER BY `history_id` Desc";				
				$num = $this->getsqlResultCount($sql);
				if($num>0){						
					$finalRes = $this->getsqlResultMultiple($sql);					
						$posts = array('success'=>'1','msg'=>'History record found','result'=>$finalRes);							
					}else{
					$posts = array('success'=>'0','msg'=>'No record found');
					}
			}else{			
				$posts = array('success'=>'0','msg'=>'Error');
			}
			echo json_encode($posts);
	   }
	   
		function wishlist_update()
		{		
			if(isset($_REQUEST['id']) && isset($_REQUEST['child_id']) && isset($_REQUEST['item']) && isset($_REQUEST['cost'])){
				$date=time();
				$sql = "UPDATE `wishlist` SET `item`= '".$_REQUEST['item']."',`cost`='".$_REQUEST['cost']."',`date`='".$date."' WHERE child_id='".$_REQUEST['child_id']."' AND id='".$_REQUEST['id']."' ";
				$rs=mysql_query($sql);			  		  
				$rows = mysql_affected_rows($this->con1);
				if($rows > 0 ){					
					$posts = array('success'=>'1','msg'=>"Wishlist updated successfully .");
				}else{					
					$posts = array('success'=>'0','msg'=>"Wishlist not updated ");
				}
			}else{
				$posts = array('success'=>'0','msg'=>'Error');
			}		 		
			echo json_encode($posts);
		}
		function wishlist_remove()
		{			
			if(isset($_REQUEST['id']) && $_REQUEST['child_id']){										
				$sql = "DELETE FROM `dragonbank_live`.`wishlist` WHERE `wishlist`.`id` = '".$_REQUEST['id']."' AND `child_id`='".$_REQUEST['child_id']."' "; 
				$rs=mysql_query($sql);			  		  
				$rows = mysql_affected_rows($this->con1);
				if($rows > 0 ){
					$post="Wishlist Deleted Successfully.";
					$posts = array('success'=>'1','msg'=>$post);	
				}else{
					$post = mysql_error($this->con1);
					$posts = array('success'=>'0','msg'=>$post);
				}
			}else{
				$posts = array('success'=>'0','msg'=>'Error');	 
			}			
			echo json_encode($posts);
		 }

	  function parentMoneyInformation()
		 {
			if(isset($_REQUEST['child_id']) && isset($_REQUEST['group_id'])){
				if($_REQUEST['group_id'] == 3){
					$child_id = $_REQUEST['child_id'];
					$sql = " SELECT `children`.*, `uc`.`user_full_name`, `up`.`user_full_name` parentname, `up`.`user_email`, `parents`.`advisor_id` FROM (`children`) JOIN `users` uc ON `uc`.`user_id` = `children`.`child_user_id` JOIN `parents` ON `parents`.`parent_id` = `children`.`parent_id` JOIN `users` up ON `up`.`user_id` = `parents`.`parent_user_id` WHERE `children`.`child_user_id` = $child_id  AND `children`.`status` = 1 ORDER BY `up`.`user_full_name` ASC, `uc`.`user_full_name` ASC";
					$row = $this->getsqlResult($sql);
					if(!empty($row)){
					extract($row);
					$data = array(
								'child_id'=>$child_id,
								'allowance'=>$allowance,
								'balance'=>$balance,
								'spend'=>$spend,
								'spend_amount'=>$spend_amount,
								'save'=>$save,
								'save_amount'=>$save_amount,
								'give'=>$give,
								'give_amount' =>$give_amount,
							);				
						$posts = array('success'=>'1','msg'=>'Record found','data'=>$data);
					}else{
						$posts = array('success'=>'0','msg'=>'No Record found');						
					}
				}else{					
					$posts = array('success'=>'0','msg'=>'Wrong group id');	
				}		
			}else{
				$posts = array('success'=>'0','msg'=>'Error');
			}
			 echo json_encode($posts);
		 }
	 
	function child_list_using_parentid()
	 {
		 if(isset($_REQUEST['parent_id'])){			
				$parent_id = $_REQUEST['parent_id'];
				  $sql = "SELECT children.child_id, children.profile_image, child_user_id, uc.user_id, children.parent_id, gender, birthday, allowance, balance, spend, spend_amount, save, save_amount, give, give_amount, children.status, parents.status as parent_status, allowance_frequency, allowance_payday, allocation_type, allowance_paydate, parent_user_id, uc.user_full_name, uc.user_name, up.user_full_name as parent_name, uc.user_email, up.user_email as parent_email, parents.advisor_id, uc.registration_date, supports FROM (`children`) 
						JOIN `parents` ON `children`.`parent_id` = `parents`.`parent_id`
						 JOIN `users` as uc ON `children`.`child_user_id` = `uc`.`user_id` AND uc.status > 0 
						 JOIN `users` as up ON `parents`.`parent_user_id` = `up`.`user_id` AND up.status > 0 
						 WHERE `parents`.`parent_user_id` = $parent_id ORDER BY `child_id` asc";

				$retval = mysql_query($sql);
				while(($data[] = mysql_fetch_assoc($retval)) || array_pop($data)); 
				$serveruri = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
				$url = substr($serveruri, 0, strpos($serveruri, "webservice"));
				$url .= 'assets/images/profiles/';
				foreach($data as $k=>$v):
					 $data[$k]['profile_image'] =   $url.$v['profile_image'];				
				endforeach;
				if(!empty($data)){
					$posts = array('success'=>'1','msg'=>'Record found','data'=>$data);		
				}else{
					$posts = array('success'=>'0','msg'=>'No Record found');
				}
		  }else{
				$posts = array('success'=>'0','msg'=>'Error');
		  }
		 echo json_encode($posts); 
	  }
	  
		function amount_show()
		{
			 if(isset($_REQUEST['child_id'])){
				$child_id = $_REQUEST['child_id'];
				$sql = "SELECT * FROM (`children`) JOIN `users` ON `child_user_id` = `user_id` WHERE `child_id` = $child_id ORDER BY `child_id` asc";								
				$row = $this->getsqlResult($sql);
				if(!empty($row)){
					extract($row);				
					$data = array(
								'child_id'=>$child_id,
								'allowance'=>$allowance,
								'balance'=>$balance,
								'spend'=>$spend,
								'spend_amount'=>$spend_amount,
								'save'=>$save,
								'save_amount'=>$save_amount,
								'give'=>$give,
								'give_amount' =>$give_amount,
							);
					$data['default'] = array( $spend, $save, $give);
					$data['spending'] = array(100, 0, 0);
					$data['saving']	= array(0, 100, 0);
					$data['giving']	= array(0, 0, 100);
					$posts = array('success'=>'1','msg'=>'Record found','data'=>$data);		
				}else{
					$posts = array('success'=>'0','msg'=>'No Record found');
				}
			}else{
				$posts = array('success'=>'0','msg'=>'Error');
			}
			echo json_encode($posts); 
		}
	  
		function amount_deposit_save()
		  {
			  if(isset($_REQUEST['child_id']) && isset($_REQUEST['allocation']) && isset($_REQUEST['money'])){
				$sql = "Select `balance`,`child_user_id`,`parent_id` FROM `children` WHERE `child_id`='".$_REQUEST['child_id']."' ";				
				$res = $this->getsqlResult($sql);
				
				$sql2 = "Select `parent_user_id` FROM `parents` WHERE `parent_id`='".$res['parent_id']."' ";				
				$result = $this->getsqlResult($sql2);
				
				$sql3 = "Select `user_name`,`user_full_name`,`user_email` FROM `users` WHERE `user_id`='".$result['parent_user_id']."' ";				
				$results = $this->getsqlResult($sql3);
				
				$sql4 = "Select `user_name` FROM `users` WHERE `user_id`='".$res['child_user_id']."' ";				
				$result1 = $this->getsqlResult($sql4);

				$sql5 = "Select `photo` FROM `advisors` WHERE `user_id`='".$result['parent_user_id']."' ";				
				$result2 = $this->getsqlResult($sql5);


				$cid =  $_REQUEST['child_id'];
				$desc = isset($_REQUEST['desc']) ? $_REQUEST['desc'] : '';
				$alloc = json_decode($_REQUEST['allocation']);					
				$total = (float)$_REQUEST["money"];			
				$money = (float)$_REQUEST["money"] * 0.01;
				$sp = (float)$money * (float)$alloc[0];
				$sa = (float)$money * (float)$alloc[1];
				$gi = (float)$money * (float)$alloc[2];
				$where = array( "child_id" => $cid );
				$type = "+";
				if( $sp > 0.00 ){				
					$this->update($where, "spend_amount", "spend_amount$type$sp");				
				}		
				if( $sa > 0.00 ){				
					$this->update($where, "save_amount", "save_amount$type$sa");				
				}			
				if( $gi > 0.00 ){				
					$this->update($where, "give_amount", "give_amount$type$gi");				
				}			
				if( $total > 0 ){			
					$this->update($where, "balance", "balance$type$total");			
				} 
				$this->saveHistory( (float)$total, $sp, $sa, $gi, $cid, $desc,'Deposit');
				$this->setAllocationAmountAchievement(4, $cid);
				$this->setAllocationAmountAchievement(5, $cid);
				$this->setAllocationAmountAchievement(6, $cid);
				$this->setAllocationAmountAchievement(7, $cid);
				$this->setAllocationAmountAchievement(8, $cid);
				$this->setAllocationAmountAchievement(9, $cid);
				$this->setAllocationAmountAchievement(10, $cid);
				$this->setWishlistAchievement($cid);		
				$total = number_format( $total, 2 );	
				$bal=$res['balance'] + $total;


				$message='<body style="background-color:#ADD8E6;" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.428571429;color:#333;background-color:#fff;">
  
  <div class="container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
  <img src="http://dragonbank.com/assets/img_mailfooter.png" alt="dargon-mail" class="mail-dragon" width="152" height="140" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;position:absolute;left:10px;bottom:6px;z-index:9;">
  	<div class="mail-container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;width:600px;margin-top:20px;margin-bottom:0;margin-right:auto;margin-left:auto;">
  		<div class="mail-header" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#ADD8E6;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;padding-bottom:9px;"><img src="http://dragonbank.com/assets/logo_v2.png" alt="mail-header" width="600" height="87" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;"></div>
  			
  		<div class="mail-content" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;position:relative;">
  		 <div class="bg-top" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;top:0;background-color:transparent;background-image:url(https://i9.createsend1.com/ei/d/87/93A/385/073655/images/mail-gradient-top.png);background-repeat:repeat-x;background-position:0 0;background-attachment:scroll;width:100%;height:35px;"></div>
	  		
	  		<div class="mail-text" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-top:70px;padding-bottom:70px;padding-right:80px;padding-left:80px;color:#666666;">
	  		 
	  			<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;line-height:1.1;font-size:12px;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;font-weight:normal!important;">Dear '.ucfirst($results['user_full_name']).',</p>
		  		<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-right:0;margin-left:0;font-size:12px;margin-bottom:5px;line-height:1.6em;">Congratulations! You and "'.ucfirst($result1['user_name']).'"have logged a deposit of $'.$total.' '.'into your Dragon Bank. The new Dragon Bank Balance is $'.$bal.'.</p>
		  		<div class="row" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:10px;margin-bottom:10px;margin-right:0;margin-left:0;">
		  			
		  				
		  			<div class="col-xs-9" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;min-height:1px;padding-right:15px;padding-left:15px;float:left;width:75%;">
		  			
		  			</div>
		  		</div>
		  		<p>Sincerely,</p>
		  		<font style="font-size:15px">Dragon bank Support team</font><br>

					 			<font style="font-size:13px">Email : <a href="support@dragonbank.com">support@dragonbank.com</a></font><br>
					 			<font style="font-size:13px">Web : <a href="www.dragonbank.com">www.dragonbank.com</a></font>
	  		
	  		</div>
	  		<div class="mail-footer" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
		  		
		  		<img src="http://dragonbank.com/assets/img_mailfooter.png" alt="dargon-mail" class="mail-dragon" width="152" height="140" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;position:absolute;right:10px;bottom:6px;z-index:9;">
		  		
	  		</div>
	  		
  		</div>
  	</div>
  
  </div> 

</body>';




				//$message = 'Dear <b>'.ucfirst($results['user_full_name']).',</b><br><br>You have deposited $'. $total .'&nbsp in your child "'.ucfirst($result1['user_name']).'"&nbsp now balance amount is $'.$bal.'.<br><br>';
				// $message = 'Dear <b>'.ucfirst($results['user_full_name']).',</b><br><br>Congratulations! You and "'.ucfirst($result1['user_name']).'"have logged a deposit of $'.$total.' '.'into your Dragon Bank. The new Dragon Bank Balance is $'.$bal.'.'.'<br><br>'.'Sincerely,'.'<br><br>';
				
				// $message .= 'Dragon bank Support team <br>';
				// $message .= 'Email: support@dragonbank.com <br>';
				// $message .= 'Web: www.dragonbank.com';
				$this->emailHelper($results['user_email'],'Dragon Bank Deposit Notice'  ,$message);
				$posts = array('success'=>'1','msg'=>'You have deposited '.$total);		
			  }else{
					$posts = array('success'=>'0','msg'=>'Error');
			  }
			 echo json_encode($posts);  
		  }
	  

		public function amount_withdraw_save()
		{
			if(isset($_REQUEST['child_id']) && isset($_REQUEST['allocation']) && isset($_REQUEST['money'])){

				$sql = "Select `child_user_id`,`balance`,`parent_id` FROM `children` WHERE `child_id`='".$_REQUEST['child_id']."' ";				
				$res = $this->getsqlResult($sql);
				
				$sql2 = "Select `parent_user_id` FROM `parents` WHERE `parent_id`='".$res['parent_id']."' ";				
				$result = $this->getsqlResult($sql2);
				
				$sql3 = "Select `user_name`,`user_full_name`,`user_email` FROM `users` WHERE `user_id`='".$result['parent_user_id']."' ";				
				$results = $this->getsqlResult($sql3);
				
				$sql4 = "Select `user_name` FROM `users` WHERE `user_id`='".$res['child_user_id']."' ";				
				$result1 = $this->getsqlResult($sql4);
				$cid =  $_REQUEST['child_id'];
				$desc = isset($_REQUEST['desc']) ? $_REQUEST['desc'] : '';
				$alloc 	= json_decode($_REQUEST['allocation']);					
				$total = (float)$_REQUEST["money"];
				$money = (float)$_REQUEST["money"] * 0.01;
				$sp = (float)$money * (float)$alloc[0];
				$sa = (float)$money * (float)$alloc[1];
				$gi = (float)$money * (float)$alloc[2];
				$type = "-";
				$checkBalance = $this->checkBalance($total, $sp, $sa, $gi, $cid );				
				if ($checkBalance != ''){
					$posts = array('success'=>'0','msg'=>$checkBalance);	
				}else{ 
					$where = array( "child_id" => $cid );			
					if( $sp > 0.00 ){
						$this->update($where, "spend_amount", "spend_amount$type$sp");
					}			
					if( $sa > 0.00 ){
						$this->update($where, "save_amount", "save_amount$type$sa");
					}			
					if( $gi > 0.00 ){
					    $this->update($where, "give_amount", "give_amount$type$gi");
					}
					if( $total > 0 ){
						$this->update($where, "balance", "balance$type$total");
					}		 
					$bal=$res['balance'] - $total;	

					if($_REQUEST['allocation'] =='[100,0,0]')
				 {
				 	 $account_name ="Spend";
				 }
				 if($_REQUEST['allocation'] =='[0,100,0]')
				 {
				 	 $account_name = "Save";
				 }
				 if($_REQUEST['allocation'] =='[0,0,100]')
				 {
				 	 $account_name = "Give";
				 }



/////////////////////////////////////////////

$message=' <body style="background-color:#ADD8E6;" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.428571429;color:#333;background-color:#fff;">
  
  <div class="container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
  
  	<div class="mail-container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;width:600px;margin-top:20px;margin-bottom:0;margin-right:auto;margin-left:auto;">
  		<div class="mail-header" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#ADD8E6;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;padding-bottom:9px;"><img src="http://dragonbank.com/assets/logo_v2.png" alt="mail-header" width="600" height="87" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;"></div>
  			
  		<div class="mail-content" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;position:relative;">
  		 <div class="bg-top" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;top:0;background-color:transparent;background-image:url(https://i9.createsend1.com/ei/d/87/93A/385/073655/images/mail-gradient-top.png);background-repeat:repeat-x;background-position:0 0;background-attachment:scroll;width:100%;height:35px;"></div>
	  		
	  		<div class="mail-text" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-top:70px;padding-bottom:70px;padding-right:80px;padding-left:80px;color:#666666;">
	  		 
	  			<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;line-height:1.1;font-size:12px;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;font-weight:normal!important;">Dear '.ucfirst($results['user_full_name']).',</p>
		  		<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-right:0;margin-left:0;font-size:12px;margin-bottom:5px;line-height:1.6em;">You and "'.ucfirst($result1['user_name']).'"have logged a withdrawl  of $'.$total.' '.'from the'.' '.$account_name.' '.'den. The new Dragon Bank Balance is $'.$bal.'.</p>
		  		<div class="row" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:10px;margin-bottom:10px;margin-right:0;margin-left:0;">
		  			
		  				
		  			<div class="col-xs-9" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;min-height:1px;padding-right:15px;padding-left:15px;float:left;width:75%;">
		  			
		  			</div>
		  		</div>
		  		<p>Sincerely,</p>
		  		<font style="font-size:15px">Dragon bank Support team</font><br>

					 			<font style="font-size:13px">Email : <a href="support@dragonbank.com">support@dragonbank.com</a></font><br>
					 			<font style="font-size:13px">Web : <a href="www.dragonbank.com">www.dragonbank.com</a></font>
	  		
	  		</div>
	  		<div class="mail-footer" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
		  		
		  		<img src="http://dragonbank.com/assets/img_mailfooter.png" alt="dargon-mail" class="mail-dragon" width="152" height="140" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;position:absolute;right:10px;bottom:6px;z-index:9;">
		  		
	  		</div>
	  		
  		</div>
  	</div>
  
  </div> 

</body>';




/////////////////////////////////////////////







				
					//if($_REQUEST['allocation'] == )
					//$message = 'Dear <b>'.ucfirst($results['user_full_name']).',</b><br><br>You have withdraw $'. $total .'&nbsp in your child "'.ucfirst($result1['user_name']).'"&nbsp now  balance amount is $'.$bal.'.<br><br>';
					//$message = 'Dear <b>'.ucfirst($results['user_full_name']).',</b><br><br>You have withdraw $'. $total .'&nbsp in your child "'.ucfirst($result1['user_name']).'"&nbsp now  balance amount is $'.$bal.'.<br><br>';
					//$message = 'Dear <b>'.ucfirst($results['user_full_name']).',</b><br><br>You and "'.ucfirst($result1['user_name']).'"have logged a withdrawl  of $'.$total.' '.'from the'.$account_name.'den .The new Dragon Bank Balance is $'.$bal.'<br><br>'.'Sincerely,'.'<br><br>'.'Dragon bank Support team'.'<br>'.'Email: support@dragonbank.com'.'<br>'.'Web: www.dragonbank.com';	
					//$message .= 'Thanks and Regards <br>';
					// $message .= 'Dragon bank Support team <br>';
					// $message .= 'Email: support@dragonbank.com <br>';
					// $message .= 'Web: www.dragonbank.com';
					$this->emailHelper($results['user_email'],'Dragon Bank Withdraw Notice',$message);	
					$this->saveHistory( (float)$total, $sp, $sa, $gi, $cid,$desc,'Withdraw');				
					$total = number_format( $total, 2 );					
					$posts = array('success'=>'1','msg'=>'You have withdrawn '.$total);	
				}	
			}else{
				$posts = array('success'=>'0','msg'=>'Error');
			}
			echo json_encode($posts);
		}
	  
		private function update($where = array(),$field = '',$operation = '',$table = 'children')
		{
			$whereField = key($where);		  
			$whereValue = $where[$whereField];
			$sql = "UPDATE $table SET $field = $operation WHERE $whereField  = 	$whereValue";
			$retval = mysql_query($sql);	
			if($retval) return true;
			else return false;
		}

		private function saveHistory( $total, $sp, $sa, $gi, $cid,$desc ='',$transection)
		{
			$rec 	 = array();		
			$sql= "SELECT `spend_amount`, `save_amount`, `give_amount` FROM (`children`) WHERE `child_id` = $cid ORDER BY `child_id` asc";
			$account = $this->getsqlResult($sql);
			$sql = "SELECT `balance` FROM (`children`) WHERE `child_id` = $cid ORDER BY `child_id` asc";
			$balance = $this->getsqlResult($sql);
			$aid = 2;
			$rec['date'] 				= date("Y-m-d");
			$rec['history_child_id'] 	= $cid;
			$rec['balance']				= (float)$balance['balance'];
			$rec['spend_history']		= $sp;
			$rec['save_history']		= $sa;
			$rec['give_history']		= $gi;
			$rec['spend_balance']		= (double)$account['spend_amount'];
			$rec['save_balance']		= (double)$account['save_amount'];
			$rec['give_balance']		= (double)$account['give_amount'];		
			if($desc != '' ) $rec['desc'] =$desc;
			$rec['credit'] 		= (float)$total;
			$rec['transaction']	= $transection;				
			if($transection == 'Deposit'){ //setFirstDepositAchievement
				$sql = "SELECT `date` FROM (`children_achievements`) WHERE `achievement_id` = 2 AND `children_id` = $cid"; 
				$sqlresult = mysql_query($sql);
				$rescount = mysql_num_rows($sqlresult);
				if($rescount == 0){		
					$date= time();
					$sql = "INSERT INTO `children_achievements` (`achievement_id`, `children_id`, `date`, `toast`, `status`) VALUES ($aid,$cid, $date, 1, 1)";
					 mysql_query($sql);				
				}
			}
			extract($rec);		//save history for transection 
			if($transaction == 'Withdraw') $column = 'debit';
			if($transaction == 'Deposit') $column = 'credit';
			$insertsql = "INSERT INTO history ".
						 "(date,history_child_id,balance,spend_history,save_history,give_history,spend_balance,save_balance,give_balance,$column,transaction,`desc`)".
						 "VALUES ".
						 "('$date','$history_child_id','$balance','$spend_history','$save_history','$give_history','$spend_balance','$save_balance','$give_balance','$credit','$transaction','$desc')";       		
			mysql_query($insertsql);
			return true;
		}

	 
		function current_profile()
		{
			 if(isset($_REQUEST['user_id']) && isset($_REQUEST['user_group'])){			 
				 $row = array();
				 $user_group = $_REQUEST['user_group'];
				 $user_id = $_REQUEST['user_id'];
				 if($user_group  == 2){
						//$sql = "SELECT t1.* FROM users t1 INNER JOIN parents t2 ON t1.user_id = t2.parent_user_id WHERE user_id =  $user_id ;";
						$sql = "SELECT * FROM users WHERE user_id =  $user_id AND  	user_group = 2 ;";
						$row = $this->getsqlResult($sql);
						if(!empty($row)){
							extract($row);
							$data = array(
								 'full_name' => $user_full_name,
								 'phone' => $user_phone,
								 'email' => $user_email
							);
							$posts = array('success'=>'1','msg'=>'Record found','data'=>$data );					
						}else{
							$posts = array('success'=>'0','msg'=>'No Record found');
						}
				 }elseif($user_group == 3){
						//$sql = "SELECT * FROM users WHERE user_id =  $user_id  AND  user_group = 3;";			  		
						$sql = "SELECT children.child_id, children.profile_image, child_user_id, uc.user_id, children.parent_id, gender, birthday, allowance, balance, spend, spend_amount, save, save_amount, give, give_amount, children.status, parents.status as parent_status, allowance_frequency, allowance_payday, allocation_type, allowance_paydate, parent_user_id, uc.user_full_name, uc.user_name, up.user_full_name as parent_name, uc.user_email, up.user_email as parent_email, parents.advisor_id, uc.registration_date, supports FROM (`children`) 
								JOIN `parents` ON `children`.`parent_id` = `parents`.`parent_id`
								JOIN `users` as uc ON `children`.`child_user_id` = `uc`.`user_id` AND uc.status > 0 
								JOIN `users` as up ON `parents`.`parent_user_id` = `up`.`user_id` AND up.status > 0 
								WHERE `children`.`child_user_id` = $user_id  ORDER BY `child_id` asc";		
						$retval = mysql_query($sql);
						while(($data[] = mysql_fetch_assoc($retval)) || array_pop($data)); 
						$serveruri = 'http://'.$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
						$url = substr($serveruri, 0, strpos($serveruri, "webservice"));
						$url .= 'assets/images/profiles/';
						foreach($data as $k=>$v):
							$data[$k]['profile_image'] =   $url.$v['profile_image'];				
						endforeach;
						if(!empty($data)){
							$posts = array('success'=>'1','msg'=>'Record found','data'=>$data);		
						}else{
							$posts = array('success'=>'0','msg'=>'No Record found');
						}			  	
				 }				
			}else{
				$posts = array('success'=>'0','msg'=>'Error');
			}		
			 echo json_encode($posts); 
		}
	  
	  function wishlist_Add_item()
	  {			
     	  if(isset($_REQUEST['item']) && isset($_REQUEST['child_id']) && isset($_REQUEST['cost'])){
				$date=time();
				$sql = "INSERT INTO `wishlist` (`item`,`child_id`,`cost`,`date`) value('".$_REQUEST['item']."','".$_REQUEST['child_id']."','".$_REQUEST['cost']."','".$date."')"; 
				$rs=mysql_query($sql);
				$itemid=mysql_insert_id();
				if($itemid==''){
					$post="No record inserted.";
					$posts = array('success'=>'0','msg'=>$post);
				}else{
					$post="record insert successfully.";
					$posts = array('success'=>'1','msg'=>$post);
			   }
		 }else{
			$posts = array('success'=>'0','msg'=>'Error');
		 }				
		echo json_encode($posts);
	   }
	   
		function show_history()
		{
			if(isset($_REQUEST['child_id'])){
				$sql = "SELECT * FROM `history` WHERE `history_child_id` ='".$_REQUEST['child_id']."' ORDER BY `date` Desc";
				$sqlresult = mysql_query($sql);
				while(($data[] = mysql_fetch_assoc($sqlresult)) || array_pop($data)); 
				foreach($data as $k => $v):					
					$data1[$data[$k]['date']][] = $v;
				endforeach;				
				foreach($data as $k => $v):					
					$date[$k] = $data[$k]['date'];
				endforeach;
				if(!empty($data1)){
					$posts = array('success'=>'1','msg'=>'Record found','data'=>$data,'date'=>$date);		
				}else{
					$posts = array('success'=>'0','msg'=>'No Record found');
				}
			}else{
				$posts = array('success'=>'0','msg'=>'Error');
			}	
			echo json_encode($posts); 
		}
		
		private function setAllocationAmountAchievement($aid,$cid) /* helper function for deposit amount set allocation amount */
		{		
			$rescount = $this->getsqlResultCount("SELECT `date` FROM (`children_achievements`) WHERE `achievement_id` = $aid AND `children_id` = $cid");
			if($rescount != 0){			
				return false;		
			}else{
				 $achievementCount = $this->getsqlResultCount("SELECT `steps`, `type` FROM (`achievements`) WHERE `id` = $aid");						
				if($achievementCount == 1){
					 $achievement = (object)$this->getsqlResult("SELECT `steps`, `type` FROM (`achievements`) WHERE `id` = $aid");				 				 
					 if (!empty($achievement->type)){				
						$save_amount = $this->getsqlResultCount("SELECT `save_amount` FROM (`children`) WHERE `child_id` = '$cid' AND `save_amount` >= '$achievement->steps'");						
						if($save_amount == 1){					
							$date= time();
							$sql = "INSERT INTO `children_achievements` (`achievement_id`, `children_id`, `date`, `toast`, `status`) VALUES ($aid,$cid, $date, 1, 1)";				
							mysql_query($sql);				      
							return true;
						}
						
					}
				}
				return false;		
			}		
		}
		
		private function setWishlistAchievement($cid)   /* helper function for deposit amount add wishlist */
		{
			$aid = 3; 
			$rescount = $this->getsqlResultCount("SELECT `date` FROM (`children_achievements`) WHERE `achievement_id` = $aid AND `children_id` = $cid");
			if($rescount != 0){			
				return false;	
			}else{		
				$result = $this->getsqlResult("SELECT `spend_amount` FROM (`children`) WHERE `child_user_id` = $cid");				 							
				$spend_amount = $result['spend_amount'];
				$wishlist = $this->getsqlResultCount("SELECT `cost` FROM (`wishlist`) WHERE `child_id` = '$cid' AND `cost` >= '$spend_amount' ");
				if($wishlist > 0){
					$date= time();
					$sql = "INSERT INTO `children_achievements` (`achievement_id`, `children_id`, `date`, `toast`, `status`) VALUES ($aid,$cid, $date, 1, 1)";				
					mysql_query($sql);			   
					return true;				
				}
			  return false;
			}
		}

		function checkBalance( $total, $sp, $sa, $gi, $cid )  /* helper function for withdraw amount */
		{		
			$msg = '' ;
			$sql = "SELECT `balance` FROM (`children`) WHERE `child_id` = $cid ORDER BY `child_id` asc";
			$balance = $this->getsqlResult($sql);
			$balance = (float)$balance['balance'];
			$sql = "SELECT `spend_amount`, `save_amount`, `give_amount` FROM (`children`) WHERE `child_id` = $cid ORDER BY `child_id` asc";
			$account = $this->getsqlResult($sql);
			if( preg_match("/^[-]/", bcsub($balance, $total, 2))){
				$msg = 'Oops! You don\'t have enough money in your Spending Account!';			
			
			}elseif( preg_match("/^[-]/", bcsub($account['spend_amount'], $sp, 2) ) ){
							$msg = 'Oops! You don\'t have enough money in your Spending Account!';			
	
			}elseif( preg_match("/^[-]/", bcsub($account['save_amount'], $sa, 2) ) ){
								$msg = 'Oops! You don\'t have enough money in your Saving Account!';			
			
			}elseif( preg_match("/^[-]/", bcsub($account['give_amount'], $gi, 2 ) ) ){
								$msg = 'Oops! You don\'t have enough money in your Giving Account!';			
		
			}
			return $msg;
		} 
		
		
		
		/* helper functions for db query */
	
		function getsqlResult($sql){
			$sqlresult = mysql_query($sql);
			$row = mysql_fetch_assoc($sqlresult);
			return $row ;
		}

		function getsqlResultCount($sql){
			$sqlresult = mysql_query($sql);		
			$rescount = mysql_num_rows($sqlresult);			  
			return $rescount;
		}

		function getsqlResultMultiple($sql){
			$sqlresult = mysql_query($sql);
			while(($data[] = mysql_fetch_assoc($sqlresult)) || array_pop($data)); 
			return $data ;
		}
		
		function update_parent_profile()
		{
	  	 if(isset($_REQUEST['parentid']) && isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['Email'])  && isset($_REQUEST['phone_number']))
	  	 {          
                         
                       
					$sql = "Select * FROM `users` WHERE `user_email`='".$_REQUEST['Email']."' AND `status`=1"; 
					$rs = mysql_query($sql); 
					$num = mysql_num_rows($rs);
					if($num == 0)	  
					{


					$sql = "Select * FROM `users` WHERE `user_id`='".$_REQUEST['parentid']."' AND `status`=1"; 
					$rs = mysql_query($sql); 
					$num = mysql_num_rows($rs);
					if($num == 1){		       
					if(isset($_REQUEST['parentid']) &&isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['Email'])  && isset($_REQUEST['phone_number']))     	        
					{
						$fullname= $_REQUEST['firstname']. ' ' .$_REQUEST['lastname'];
						if(isset($_REQUEST['password']) && $_REQUEST['password'] != ''	){
							$user_password = md5($_REQUEST['password']);					
							$sql = "UPDATE `users` set `user_full_name`='".$fullname."',`user_email`='".$_REQUEST['Email']."',`user_phone`='".$_REQUEST['phone_number'] ."',`user_password`='".$user_password ."' where user_id='".$_REQUEST['parentid']."'";				
						}else{						
							$sql = "UPDATE `users` set `user_full_name`='".$fullname."',`user_email`='".$_REQUEST['Email']."',`user_phone`='".$_REQUEST['phone_number'] ."' where user_id='".$_REQUEST['parentid']."'";												
						}
						$rs= mysql_query($sql);			
						$posts = array('success'=>'1','msg'=>"Profile is Updated");
					}
					}else{
					$post="Data not Found";
					$posts = array('success'=>'0','msg'=>$post);
					}

				}

				else{
					$post="Data not Found";
					$posts = array('success'=>'0','msg'=>'Email already Registered');
					}
			}
		  echo json_encode($posts);
		}
	 function update_child_profile()
	 {
		if(isset($_REQUEST['child_id'])){
			$sql = "Select * FROM `users` WHERE `user_id`='".$_REQUEST['child_id']."' AND `status`=1"; 
			$num = $this->getsqlResultCount($sql);
			if($num == 1){					
				if(count($_REQUEST) > 2){	
					if(isset($_REQUEST['user_name']) && $_REQUEST['user_name'] != '' || isset($_REQUEST['firstname']) && $_REQUEST['firstname'] != '' && isset($_REQUEST['lastname']) && $_REQUEST['lastname'] != '' || isset($_REQUEST['password']) && $_REQUEST['password'] != '' || isset($_REQUEST['allowance_payday']) && $_REQUEST['allowance_payday'] != ''){				
						$query = "UPDATE `users` SET ";
						if(isset($_REQUEST['user_name']) && !empty($_REQUEST['user_name'])) $query .= " `users`.`user_name`='".$_REQUEST['user_name']."',";						
						if(isset($_REQUEST['firstname']) && !empty($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && !empty($_REQUEST['lastname'])) $query .= " `users`.`user_full_name`='".$_REQUEST['firstname']. ' ' .$_REQUEST['lastname']."',";						
						if(isset($_REQUEST['password']) && $_REQUEST['password'] != '') $query .= " `users`.`user_password`='".md5($_REQUEST['password'])."',";
						$query =substr($query, 0, -1);					
						$sql = $query." WHERE `user_id` = '".$_REQUEST['child_id']."'";										
						$rs= mysql_query($sql);
						echo mysql_error($this->con1);
					}
					if(isset($_REQUEST['birthday']) && $_REQUEST['birthday'] != '' || isset($_REQUEST['allowance']) && $_REQUEST['allowance'] != '' || isset($_REQUEST['allowance_frequency']) && $_REQUEST['allowance_frequency'] != '' || isset($_REQUEST['allowance_payday']) && $_REQUEST['allowance_payday'] != ''){
						$child_idimage=$_REQUEST['child_id'];
						$filename = @$_FILES['image']['name'];

						if(!empty($filename)){
						$name = $child_idimage.$filename;
						$tfilename = @$_FILES['image']['tmp_name'];
						$dir = '../assets/images/profiles/';
						$path = $dir.$name;
						$myfile= move_uploaded_file($tfilename,$path);
						$query = "UPDATE `children` SET ";
						if(isset($_REQUEST['birthday']) && $_REQUEST['birthday'] != '') $query .= " `birthday` ='".$_REQUEST['birthday']."',";
						if(isset($_REQUEST['allowance']) && $_REQUEST['allowance'] != '') $query .= " `allowance`='".$_REQUEST['allowance']."',";
						if(isset($_REQUEST['allowance_frequency']) && $_REQUEST['allowance_frequency'] != '') $query .= " `allowance_frequency`='".$_REQUEST['allowance_frequency']."',";
						if(isset($_REQUEST['allowance_payday']) && $_REQUEST['allowance_payday'] != '') $query .= " `allowance_payday`='".$_REQUEST['allowance_payday']."',";
						$query .= " `profile_image`='".$name."',";
				      	}
				      	else
				      	{
				      		$query = "UPDATE `children` SET ";
						if(isset($_REQUEST['birthday']) && $_REQUEST['birthday'] != '') $query .= " `birthday` ='".$_REQUEST['birthday']."',";
						if(isset($_REQUEST['allowance']) && $_REQUEST['allowance'] != '') $query .= " `allowance`='".$_REQUEST['allowance']."',";
						if(isset($_REQUEST['allowance_frequency']) && $_REQUEST['allowance_frequency'] != '') $query .= " `allowance_frequency`='".$_REQUEST['allowance_frequency']."',";
						if(isset($_REQUEST['allowance_payday']) && $_REQUEST['allowance_payday'] != '') $query .= " `allowance_payday`='".$_REQUEST['allowance_payday']."',";
						
				      	}

						
						$query =substr($query, 0, -1);					
						$sql = $query." WHERE `child_user_id` = '".$_REQUEST['child_id']."'";										
						$rs= mysql_query($sql);
						echo mysql_error($this->con1);
					}
					$post="Profile is Updated";
					$posts = array('success'=>'1','msg'=>$post,'image'=>$filename);
				}else{
					$post="No Updates";
					$posts = array('success'=>'1','msg'=>$post);	
				}
			}else{
				$post="Data not Found";
				$posts = array('success'=>'0','msg'=>$post);
			}
			// $sql = "UPDATE `users` set`user_full_name`='".$fullname."',`user_name`='".$_REQUEST['firstname']."',`user_password`='".$user_password."',`user_phone`='".$_REQUEST['phone_number'] ."' where user_id='".$_REQUEST['childid']."'";					
		}
	  echo json_encode($posts);
	}
	
	 function update_child_profile_bkp(){
				if(isset($_REQUEST['childid']) && isset($_REQUEST['firstname']) && isset($_REQUEST['lastname'])  && isset($_REQUEST['phone_number'])){
					$sql = "Select * FROM `users` WHERE `user_id`='".$_REQUEST['childid']."' AND `status`=1"; 
					$rs = mysql_query($sql);
					$num = mysql_num_rows($rs);
					if($num == 1){		       
					if(isset($_REQUEST['childid']) &&isset($_REQUEST['firstname']) && isset($_REQUEST['lastname']) && isset($_REQUEST['phone_number']))     	        
					{
					$fullname= $_REQUEST['firstname']. ' ' .$_REQUEST['lastname'];
					if(isset($_REQUEST['password']) && $_REQUEST['password'] != ''){
					$user_password = md5($_REQUEST['password']);
					$sql = "UPDATE `users` set`user_full_name`='".$fullname."',`user_name`='".$_REQUEST['firstname']."',`user_password`='".$user_password."',`user_phone`='".$_REQUEST['phone_number'] ."' where user_id='".$_REQUEST['childid']."'";
					}else{
					$sql = "UPDATE `users` set`user_full_name`='".$fullname."',`user_name`='".$_REQUEST['firstname']."',`user_phone`='".$_REQUEST['phone_number'] ."' where user_id='".$_REQUEST['childid']."'";	
					}
					$rs= mysql_query($sql);
					$post="Profile is Updated";
					$posts = array('success'=>'1','msg'=>$post);
					}
					}else{
					$post="Data not Found";
					$posts = array('success'=>'0','msg'=>$post);
					}
			}
		  echo json_encode($posts);
	}
	
	function forget_pass_child()
	{
		if(isset($_REQUEST['username'])){
			$uname = $_REQUEST['username'];			
			$sql = "SELECT up.user_email,up.user_id,up.user_full_name FROM (`children`) 
					 RIGHT OUTER JOIN `users` uc ON `uc`.`user_id` = `children`.`child_user_id`
					 JOIN `parents` ON `parents`.`parent_id` = `children`.`parent_id` 
					 JOIN `users` up ON `up`.`user_id` = `parents`.`parent_user_id`
					  WHERE `uc`.`user_name` = '$uname' AND `children`.`status` = 1 ORDER BY `up`.`user_full_name` ASC, `uc`.`user_full_name` ASC";								
			$res = $this->getsqlResult($sql);
			$email=$res['user_email'];
			if(!empty($res) && $res['user_id'] != ''){
				$uniqPass = $this->generatePasswordHelper(6);
				$sql = "UPDATE `users` set `user_password`='".md5($uniqPass)."' where user_name='".$uname."'";
				mysql_query($sql);
				if(mysql_affected_rows() == '1'){
					$message = '<div style="background-color:#ADD8E6;"><b>Dragon bank</b></br></br>
					Dear <b>'.$res['user_full_name'].'</b></br></br> Your password has been updated successfully,</br> And your password : <b>'.$uniqPass.' </b></br></br>
					Great money habits learned early, make a big difference in your childs life.</br></br>
					If you did not request this information, we apologize for the error. Another member may have inadvertently entered the incorrect Member Name on the Password Recovery form, which prompted this email to be sent.<br><br></div>';

					$message .= '<div style="background-color:#ADD8E6;">Sincerely,</br></br></div>';
					$message .= '<div style="background-color:#ADD8E6;"><b>Dragon bank Support team</b><br><br>
								Email : <a href="support@dragonbank.com">support@dragonbank.com</a><br>
								Web : <a href="www.dragonbank.com">www.dragonbank.com</a></div>';
					$this->emailHelper($email,'Child forget password',$message);
					$posts = array('success'=>'1','msg'=>'Child Profile is Updated');					
				}else{					
					$posts = array('success'=>'0','msg'=>'Password Update occured error');
				}					
			}else{
				$posts = array('success'=>'0','msg'=>'Child doesn\'t Exists');										
			}
		}else{
			$posts = array('success'=>'0','msg'=>'Error');
		}	
		echo json_encode($posts); 
	}
	
		function child_histry_detail()
		{
				$history_id=$_REQUEST['history_id'];
				$child_id=$_REQUEST['child_id'];
				require("fpdf17/fpdf.php");
				$pdf = new FPDF();
				$pdf->AddPage();
				$pdf->SetFont('Arial','B',9);
				$pdf->Cell(20,10, 'Transaction' ,1);
				$pdf->Cell(20,10, 'Debit' ,1);
				$pdf->Cell(20,10, 'Credit' ,1); 
				$pdf->Cell(20,10, 'Balance',1);
				$pdf->Cell(40,10, 'Desc' ,1);
				$pdf->Cell(40,10, 'Date','TLRB','1' ,1);
				$queryexport = ("SELECT * FROM history where history_child_id=$child_id ORDER BY `history_id` ASC");
				$result = mysql_query($queryexport);
				while($row_user = mysql_fetch_array($result)){
					$userinfo[] = $row_user; 
				}
				//foreach ($userinfo as $value) {
				//$pdf->Cell(20,10, $value['transaction'],1);
				//$pdf->Cell(20,10, $value['debit'] ,1);
				//$pdf->Cell(20,10, $value['credit'] ,1);
				//$pdf->Cell(20,10, $value['balance'] ,1);
				//$pdf->Cell(40,10, $value['desc'] ,1);
				//$pdf->Cell(20,10, $value['date'] ,1);
				//require('fpdf18/fpdf1.php');
				//$pdf = new FPDF();
				//$pdf->AddPage();

				foreach($userinfo as $rowValue) {
				$pdf->SetFont('Arial','',8);	
				$pdf->Cell(20,10,$rowValue['transaction'],1);
				$pdf->Cell(20,10,$rowValue['debit'],1);
				$pdf->Cell(20,10,$rowValue['credit'],1);
				$pdf->Cell(20,10,$rowValue['balance'],1);
				$pdf->Cell(40,10,$rowValue['desc'],1);
				$pdf->Cell(40,10,$rowValue['date'],1);
				$pdf->Ln();
				}
				
				$sql = "SELECT * from children INNER JOIN parents on children.parent_id = parents.parent_id INNER JOIN users on parents.parent_user_id = users.user_id where children.child_id=$child_id";
				$sql_query=mysql_query($sql);
				$sql_fetch = mysql_fetch_array($sql_query);
				$parents_mail=$sql_fetch['user_email'];
				$user_id=$sql_fetch['child_user_id'];
				$querys = "SELECT `user_name` FROM users where user_id=$user_id";
				$user_name = $this->getsqlResult($querys);
				//	$pdf->Output(); //default output to browser
				// $pdf->Output( '', 'S' ) 

			// 	include 'library.php'; 
			// include "classes/class.phpmailer.php";		
			// $mail	= new PHPMailer; // call the class 
			// $mail->IsSMTP(); 
			// $mail->Host = "intelq.com"; //Hostname of the mail server
			// $mail->Port = 587; //Port of the SMTP like to be 25, 80, 465 or 587
			// $mail->SMTPAuth = true; //Whether to use SMTP authentication
			// $mail->SMTPSecure = "tls";
			// $mail->Username = "pravesh@intelq.com"; //Username for SMTP authentication any valid email created in your domain
			// $mail->Password = "pravesh"; //Password for SMTP authentication		
			// $mail->SetFrom("pravesh@intelq.com"); //From address of the mail
			// $mail->Subject = $subject; //Subject od your mail
			// $mail->AddAddress($to); //To address who will receive this email		
			// $mail->MsgHTML($message); //Put your body of the message you can place html code here
			// $send = $mail->Send();
			// if($send) return true;
			// else return false;
                       
                       ///////////////////////////////////////





				include 'library.php'; 
				include "classes/class.phpmailer.php";
				$mail	= new PHPMailer; // call the class 
				$mail->IsSMTP(); 
				$mail->Host = "mail.dragonbank.com"; //Hostname of the mail server
				$mail->Port = 587; //Port of the SMTP like to be 25, 80, 465 or 587
				$mail->SMTPAuth = true; //Whether to use SMTP authentication
				$mail->SMTPSecure = "tls";
				$mail->Username = "support@dragonbank.com"; //Username for SMTP authentication any valid email created in your domain
				$mail->Password = "M8AMvEwNxesq"; //Password for SMTP authentication
				//$mail->AddReplyTo('akhilesh.tenguriya7@gmail.com'); //reply-to address
				$mail->SetFrom("support@dragonbank.com"); //From address of the mail
				$mail->Subject = "Dragon Bank Account Summary"; //Subject od your mail 
				$mail->AddAddress($parents_mail); //To address who will receive this email
				//$mail->MsgHTML('Dear <b>'.$sql_fetch['user_full_name'].'</b>,<br><br>Please find attached your Dragon Bank Account Summary for <b>"'.$user_name['user_name'].'"</b>This summary represents each of the Dragon Bank transactions you have logged inside the Dragon Bank App.'.'<br><br>'.'This is a great document to share and review with'.' '.$user_name['user_name'].' '.','.' to help them learn the importance and the skills required to track all of their money and spending as they get older. '.'<br><br>'.'Sincerely,'.'<br><br>'.'Dragon bank Support team'.'<br>'.'Email: support@dragonbank.com'.'<br>'.'Web: www.dragonbank.com'); //Put your body of the message you can place html code here
				$mail->MsgHTML('<body style="background-color:#ADD8E6;" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.428571429;color:#333;background-color:#fff;">
<div class="container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">

<div class="mail-container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;width:600px;margin-top:20px;margin-bottom:0;margin-right:auto;margin-left:auto;">
<div class="mail-header" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#ADD8E6;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;padding-bottom:9px;"><img src="http://dragonbank.com/assets/logo_v2.png" alt="mail-header" width="600" height="87" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;"></div>

   		<div class="mail-content" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;position:relative;">
   		 <div class="bg-top" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;top:0;background-color:transparent;background-image:url(https://i9.createsend1.com/ei/d/87/93A/385/073655/images/mail-gradient-top.png);background-repeat:repeat-x;background-position:0 0;background-attachment:scroll;width:100%;height:35px;"></div>
	  		
 	  		<div class="mail-text" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-top:70px;padding-bottom:70px;padding-right:80px;padding-left:80px;color:#666666;">
<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;line-height:1.1;font-size:12px;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;font-weight:normal!important;">Dear '.ucfirst($sql_fetch['user_full_name']).',</p>
<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-right:0;margin-left:0;font-size:12px;margin-bottom:5px;line-height:1.6em;">Please find attached your Dragon Bank Account Summary for <b>"'.$user_name['user_name'].'"</b>This summary represents each of the Dragon Bank transactions you have logged inside the Dragon Bank App.'.'<br><br>'.'This is a great document to share and review with'.' '.$user_name['user_name'].' '.','.' to help them learn the importance and the skills required to track all of their money and spending as they get older</p>
<div class="row" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:10px;margin-bottom:10px;margin-right:0;margin-left:0;">
		  			
		  				
		  			<div class="col-xs-9" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;min-height:1px;padding-right:15px;padding-left:15px;float:left;width:75%;">
		  			
		  			</div>
		  		</div>
		  		<p>Sincerely,</p>
		  		<font style="font-size:15px">Dragon bank Support team</font><br>

					 			<font style="font-size:13px">Email : <a href="support@dragonbank.com">support@dragonbank.com</a></font><br> 					 			<font style="font-size:13px">Web : <a href="www.dragonbank.com">www.dragonbank.com</a></font>
	  		
 	  		</div>
	  		<div class="mail-footer" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
		  		
		  		<img src="http://dragonbank.com/assets/img_mailfooter.png" alt="dargon-mail" class="mail-dragon" width="152" height="140" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;position:absolute;right:10px;bottom:6px;z-index:9;">
	  		
 	  		</div>
	  		
   		</div>
   	</div>
  
   </div> 
</div>
</div>
</body>'); //Put your body of the message you can place html code here
				$mail->AddStringAttachment($pdf->Output("accounthistry.pdf", "S"), 'accounthistry.pdf', 'base64', 'application/octet-stream');	
				$send = $mail->Send(); //Send the mails
				if($send){
					$msg="child account history is send to Email";
				$posts = array('success'=>'1','msg'=>$msg);	
					}else{
						$msg="child account history not send";
				$posts = array('success'=>'1','msg'=>$msg);	
						}
				/*************** mail send end   ****************/
			   echo json_encode($posts);
			}
	
	function forget_pass_parent()
	{
		if(isset($_REQUEST['email'])){
			$email = $_REQUEST['email'];			
			$sql = "SELECT `user_id`,`user_full_name` FROM (`users`) WHERE  `users`.`user_email` = '$email'";
			$res = $this->getsqlResult($sql);
			if(!empty($res) && $res['user_id'] != ''){		
				$uniqPass = $this->generatePasswordHelper(6);
				$sql = "UPDATE `users` set `user_password`='".md5($uniqPass)."' where user_id='".$res['user_id']."'";
				mysql_query($sql);
				if(mysql_affected_rows() == '1'){


					$message=' <body style="background-color:#ADD8E6;" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.428571429;color:#333;background-color:#fff;">
  
  <div class="container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
  
  	<div class="mail-container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;width:600px;margin-top:20px;margin-bottom:0;margin-right:auto;margin-left:auto;">
  		<div class="mail-header" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;padding-bottom:9px;"><img src="http://dragonbank.com/assets/logo_v2.png" alt="mail-header" width="600" height="87" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;"></div>
  			
  		<div class="mail-content" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;position:relative;">
  		 <div class="bg-top" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;top:0;background-color:transparent;background-image:url(https://i9.createsend1.com/ei/d/87/93A/385/073655/images/mail-gradient-top.png);background-repeat:repeat-x;background-position:0 0;background-attachment:scroll;width:100%;height:35px;"></div>
	  		
	  		<div class="mail-text" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-top:70px;padding-bottom:70px;padding-right:80px;padding-left:80px;color:#666666;">
	  		
	  			<h3 style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-weight:500;line-height:1.1;font-size:14px;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;">Dear <b>'.$res['user_full_name'].'</h3>
		  		<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-right:0;margin-left:0;font-size:12px;margin-bottom:5px;line-height:1.6em;">Your password has been updated successfully,</br> And your password : <b style="color:Black;">'.$uniqPass.' </b></br></br>
					Great money habits learned early, make a big difference in your childs life.</br></br>
					If you did not request this information, we apologize for the error. Another member may have inadvertently entered the incorrect Member Name on the Password Recovery form, which prompted this email to be sent.</p>
		  		<div class="row" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:10px;margin-bottom:10px;margin-right:0;margin-left:0;">
		  			<b style="font-size:18px">Dragon bank Support team</b><br>
					 			<b style="font-size:13px">Email : <a href="support@dragonbank.com">support@dragonbank.com</a></b><br>
					 			<b style="font-size:13px">Web : <a href="www.dragonbank.com">www.dragonbank.com</a></b>
		  				
		  			<div class="col-xs-9" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;min-height:1px;padding-right:15px;padding-left:15px;float:left;width:75%;">
		  			
		  			</div>
		  		</div>
		  		
		  		<p class="mail-contact" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-right:0;margin-left:0;margin-bottom:5px;line-height:1.6em;margin-top:130px;font-size:10px;">Contact : <a href="mailto:support@DragonBank.com" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;color:#428bca;text-decoration:none;">support@DragonBank.com</a> with questions</p>
	  		
	  		</div>
	  		<div class="mail-footer" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
		  		
		  		<img src="https://i6.createsend1.com/ei/d/87/93A/385/073655/images/dargon-mail.png" alt="dargon-mail" class="mail-dragon" width="202" height="170" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;position:absolute;right:10px;bottom:6px;z-index:9;">
		  		<div class="bg-bottom" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;bottom:0;background-color:transparent;background-image:url(https://i10.createsend1.com/ei/d/87/93A/385/073655/images/mail-gradient-bottom.png);background-repeat:repeat-x;background-position:0 0;background-attachment:scroll;width:100%;height:70px;"><div class="mail-copy" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-top:45px;padding-bottom:10px;padding-right:0;padding-left:26px;font-size:11px;color:#666;">www.DragonBank.com   |   ©&nbsp;2013 EnRICHed Academy</div></div>
	  		</div>
	  		
  		</div>
  	</div>
  
  </div> 

</body>';


					// $message = '<img src="https://i6.createsend1.com/ei/d/87/93A/385/073655/images/dargon-mail.png" alt="dargon-mail" class="mail-dragon" width="202" height="170" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;position:absolute;right:10px;bottom:6px;z-index:9;"><br><br><div style="background-color:#ADD8E6;"><b>Dragon bank</b></br></br>

					// Dear <b>'.$res['user_full_name'].'</b></br></br> Your password has been updated successfully,</br> And your password : <b>'.$uniqPass.' </b></br></br>
					// Great money habits learned early, make a big difference in your childs life.</br></br>
					// If you did not request this information, we apologize for the error. Another member may have inadvertently entered the incorrect Member Name on the Password Recovery form, which prompted this email to be sent.<br><br></div>';


					// $message .= '<div style="background-color:#ADD8E6;">Sincerely,</br></br></div>';



					// $message .= '<div style="background-color:#ADD8E6;"><b>Dragon bank Support team</b><br><br>
					// 			Email : <a href="support@dragonbank.com">support@dragonbank.com</a><br>
					// 			Web : <a href="www.dragonbank.com">www.dragonbank.com</a></div>';


					$this->emailHelper($email,'Parent forget password',$message);
					$posts = array('success'=>'1','msg'=>'Parent Profile is Updated');					
				}else{					
					$posts = array('success'=>'0','msg'=>'Password Update occured error');
				}
				
			}else{
				$posts = array('success'=>'0','msg'=>'Parent doesn\'t Exists');										
			}
		}else{
			$posts = array('success'=>'0','msg'=>'Error');
		}	
		echo json_encode($posts); 
	}
	
	
	function generatePasswordHelper($length = 10) {
		$alphabets = range('A','Z');
		$small_alphabets = range('a','z');
		$numbers = range('0','9');
		
		$final_array = array_merge($alphabets,$numbers,$small_alphabets);
			 
		$password = '';
	  
		while($length--) {
		  $key = array_rand($final_array);
		  $password .= $final_array[$key];
		}	  
		return $password;
	}
	
	function setting()
		{
	  	 if(isset($_REQUEST['parentid']) && isset($_REQUEST['allowance_reminder']) && isset($_REQUEST['saving_giving_reminder']) && isset($_REQUEST['automate_allowance']))
	  	 {	 
			$sql = "UPDATE `parents` set `allowance_reminder`= '".$_REQUEST['allowance_reminder']."',`quarterly_reminder`= '".$_REQUEST['saving_giving_reminder']."',`allowance_status`= '".$_REQUEST['automate_allowance']."' where parent_user_id='".$_REQUEST['parentid']."'";				
			$rs= mysql_query($sql);
			$rows = mysql_affected_rows();
			if($rows > 0 ){					
					$posts = array('success'=>'1','msg'=>"Profile updated successfully .");
				}else{					
					$posts = array('success'=>'0','msg'=>"Profile not updated ");
				}
		}else{
			$post="Data not Found";
			$posts = array('success'=>'0','msg'=>$post);
			}
	  echo json_encode($posts);
	}
	
	function show_setting()
		{
	  	 if(isset($_REQUEST['userid']))
	  	 {	 
			$sql = "SELECT `allowance_reminder`,`quarterly_reminder`,`allowance_status` FROM (`parents`) WHERE  `parents`.`parent_user_id` = '".$_REQUEST['userid']."'";		
			$res = $this->getsqlResult($sql);
			$rs = mysql_query($sql);
			$num = mysql_num_rows($rs);//print_r($num);
			if($num){
					$posts = array('Allowance Reminder'=>$res['allowance_reminder'],'Savings & Giving Reminder'=>$res['quarterly_reminder'],'Automate Allowance'=>$res['allowance_status'],'success'=>'1','msg'=>"Result show above");
				}else{
					$posts = array('success'=>'1','msg'=>"Result not show");
					}
			}
			else{
				$post="Data not Found";
				$posts = array('success'=>'0','msg'=>$post);
				}
		  echo json_encode($posts);
			}
	
	
	
		function emailHelper($to,$subject,$message)	
		{		
			include 'library.php'; 
			include "classes/class.phpmailer.php";		
			$mail	= new PHPMailer; // call the class 
			$mail->IsSMTP(); 
			$mail->Host = "mail.dragonbank.com"; //Hostname of the mail server
			$mail->Port = 587; //Port of the SMTP like to be 25, 80, 465 or 587
			$mail->SMTPAuth = true; //Whether to use SMTP authentication
			$mail->SMTPSecure = "tls";
			$mail->Username = "support@dragonbank.com"; //Username for SMTP authentication any valid email created in your domain
			$mail->Password = "M8AMvEwNxesq"; //Password for SMTP authentication		
			$mail->SetFrom("support@dragonbank.com"); //From address of the mail
			$mail->Subject = $subject; //Subject od your mail
			$mail->AddAddress($to); //To address who will receive this email		
			$mail->MsgHTML($message); //Put your body of the message you can place html code here
			$send = $mail->Send();
			if($send) return true;
			else return false;
		}

		function auto_email_weekly()
		{
			$sql = "SELECT * FROM `children` WHERE allowance_frequency = 'week'";
			$query = mysql_query($sql);
			while($x = mysql_fetch_assoc($query))
			{
				$parentid = $x['parent_id'];
				$child_user_id = $x['child_user_id'];
				$allowance = $x['allowance'];
				$spend_amount = $x['spend_amount'];
				$save_amount = $x['save_amount'];
				$give_amount = $x['give_amount'];
				$spend_per = $x['spend'];
				$save_per = $x['save'];
				$give_per = $x['give'];
				$genders = $x['gender'];
				if($genders == 'Male')
					$gender = 'his';
				if($genders == 'Female')
					$gender = 'her';

				$sql1 = "SELECT * FROM parents WHERE parent_id=$parentid";
				$query1 = mysql_query($sql1);
				$fetch_data = mysql_fetch_assoc($query1);
				$parentuserid = $fetch_data['parent_user_id'];
				$parentemail = $fetch_data['user_email'];

				$sql2 = "SELECT * FROM users WHERE user_id=$parentuserid";
				$query2 = mysql_query($sql2);
				$fetch_data2 = mysql_fetch_assoc($query2);
				$parentusername = $fetch_data2['user_full_name'];
				$parentemail = $fetch_data2['user_email'];

				$sql3 = "SELECT * FROM users WHERE user_id=$child_user_id";
				$query3 = mysql_query($sql3);
				$fetch_data3 = mysql_fetch_assoc($query3);
				$childname = $fetch_data3['user_full_name'];

				$sql4 = "SELECT * FROM advisors WHERE user_id=$parentuserid";
				$query4 = mysql_query($sql4);
				$fetch_data4 = mysql_fetch_assoc($query4);
				$photo = $fetch_data4['photo'];
				if($photo == '')
				{
					$advisor_image = '<img src="http://dragonbank.com/assets/dummy.jpg" alt="dargon-mail"  class="mail-dragon" width="100%;">';
				}
				else
				{
					$advisor_image = '<img src="http://dragonbank.com/assets/"<?php echo $photo ?>'.'alt="dargon-mail"  class="mail-dragon" width="100%;">';
				}

				$date= date('Y-m-d');
                $week_daysnum = $x['allowance_payday'];
                $day = date('l', strtotime( $date));
                $daynum = date("N", strtotime($day));
                if($daynum == $week_daysnum)
                {


              ///////////////////////////////

               $message=' <body style="background-color:#ADD8E6;" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.428571429;color:#333;background-color:#fff;">
  
  <div class="container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
  
    <div class="mail-container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;width:600px;margin-top:20px;margin-bottom:0;margin-right:auto;margin-left:auto;">
      <div class="mail-header" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#ADD8E6;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;padding-bottom:9px;"><img src="http://dragonbank.com/assets/logo_v2.png" alt="mail-header" width="600" height="87" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;"></div>
        
      <div class="mail-content" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;position:relative;">
       <div class="bg-top" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;top:0;background-color:transparent;background-image:url(https://i9.createsend1.com/ei/d/87/93A/385/073655/images/mail-gradient-top.png);background-repeat:repeat-x;background-position:0 0;background-attachment:scroll;width:100%;height:35px;"></div>

       <div style="display: table; width: auto; padding: 50px 20px 20px 20px;">
          
        <div style="display:table-cell; width: 30%;  vertical-align: top; border-right: 1px solid #cccccc;"><div style="padding:0 15px;">'.$advisor_image.'

        <p style="text-align:center; border-bottom:1px solid #ccc; padding: 4px 0;margin:0;">Investors Group</p><p style="text-align:center;margin:0;padding: 4px 0;">Adviser Name</p>
        
        </div></div>
        
        <div class="mail-text"  style="display:table-cell;vertical-align:top;position:relative;">
         
          <p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;line-height:1.1;font-size:12px;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;font-weight:normal!important;padding-left:10px;"><b>Allowance Reminder:<b><br>Hi '.ucfirst($results['user_full_name']).',</p>

          <p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-right:0;margin-left:0;font-size:12px;margin-bottom:5px;line-height:1.6em;padding-left:10px;">As a reminder, today is the day to pay.'.' '.@$childname.' '.'Weekly allowance. With'.' '.@$childname.' '.'please deposit'.' '.$allowance.' '.'into'.$gender.'Dragon Bank today and remember to record the deposit through your online Dragon Bank account'."<br><br>".@$childnames.' '.'Current Balance Before Today Allowance:'.' '.$allowance."<br><br>".'Spend Den:'.' '.$spend_amount."<br>".'Save Den:'.' '.$save_amount."<br>".'Give Den:'.$give_amount."<br><br>".'As a reminder, you and'.' '.@$childnames.' '.'have your Dragon Bank allocation set up as Den Allocation'.' '."<b>".'Save:'.@$save_per.'%'."</b>".' '.' '."<b>".'Spend:'.@$spend_per.'%'."</b>".' '.' '."<b>".'Give:'.@$give_per.'%.'."</b>"."<br><br><br>"."
            Each and every time you complete this process with".' '.@$childname.' '.", she further ingrains these important wealth building disciplines and habits into her routine. Thank you for being so proactive in teaching".' '.@$childname.' '.'about money!</p>

          <div class="row" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:10px;margin-bottom:10px;margin-right:0;margin-left:0;">
            
              
            <div class="col-xs-9" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;min-height:1px;padding-right:15px;padding-left:15px;float:left;width:75%;">
            
            </div>
          </div>
          <p style="padding-left:10px;">Sincerely,</p>
          <font style="font-size:15px;padding-left:10px;">Dragon bank Support team</font><br>

                <font style="font-size:13px;padding-left:10px;">Email : <a href="support@dragonbank.com">support@dragonbank.com</a></font><br>
                <font style="font-size:13px;padding-left:10px;">Web : <a href="www.dragonbank.com">www.dragonbank.com</a></font>
        
        </div>
        <div class="mail-footer" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
          
          <img src="http://dragonbank.com/assets/img_mailfooter.png" alt="dargon-mail" class="mail-dragon" width="152" height="140" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;position:absolute;right:10px;bottom:6px;z-index:9;">
          
        </div>
        
      </div>
    </div>
  
  </div> 

</body>';

              
              ///////////////////////////////  	

            // $msg = '<b>'.'Allowance Reminder:'.'</b>'."<br><br><br>"."Hi".' '.$parentusername.','."<br><br>"."As a reminder, today is the day to pay".' '.@$childname.' '.'Weekly allowance. With'.' '.@$childname.' '.'please deposit'.' '.$allowance.' '.'into'.$gender.'Dragon Bank today and remember to record the deposit through your online Dragon Bank account'."<br><br>".@$childnames.' '.'Current Balance Before Today Allowance:'.' '.$allowance."<br><br><br>".'Spend Den:'.' '.$spend_amount."<br>".'Save Den:'.' '.$save_amount."<br>".'Give Den:'.$give_amount."<br><br>".'As a reminder, you and'.' '.@$childnames.' '.'have your Dragon Bank allocation set up as Den Allocation'.' '."<b>".'Save:'.@$save_per.'%'."</b>".' '.' '."<b>".'Spend:'.@$spend_per.'%'."</b>".' '.' '."<b>".'Give:'.@$give_per.'%.'."</b>"."<br><br><br>"."
            // Each and every time you complete this process with".' '.@$childname.' '.", she further ingrains these important wealth building disciplines and habits into her routine. Thank you for being so proactive in teaching".' '.@$childname.' '. 'about money!'."<br><br>"."Sincerely,"."<br>".' '."The Dragon Bank Support Team"."<br>".'Email: support@dragonbank.com'."<br>".'Web: www.dragonbank.com';
					include 'library.php'; 
					include "classes/class.phpmailer.php";		
					$mail	= new PHPMailer; // call the class 
					$mail->IsSMTP(); 
					$mail->Host = "mail.dragonbank.com"; //Hostname of the mail server
					$mail->Port = 587; //Port of the SMTP like to be 25, 80, 465 or 587
					$mail->SMTPAuth = true; //Whether to use SMTP authentication
					$mail->SMTPSecure = "tls";
					$mail->Username = "support@dragonbank.com"; //Username for SMTP authentication any valid email created in your domain
					$mail->Password = "M8AMvEwNxesq"; //Password for SMTP authentication		
					$mail->SetFrom("support@dragonbank.com"); //From address of the mail
					$mail->Subject = "Dragon Bank Reminder"; //Subject od your mail
					$mail->AddAddress($parentemail); //To address who will receive this email		
					$mail->MsgHTML($message); //Put your body of the message you can place html code here
					$send = $mail->Send();
					if($send) return true;
					else return false;
                }


			}
		}



		
 

          function auto_email_monthly()
		{
		   $sql = "SELECT * FROM `children` WHERE allowance_frequency = 'month'";
			$query = mysql_query($sql);
			while($x = mysql_fetch_assoc($query))
			{
				$parentid = $x['parent_id'];
				$child_user_id = $x['child_user_id'];
				$allowance = $x['allowance'];
				$spend_amount = $x['spend_amount'];
				$save_amount = $x['save_amount'];
				$give_amount = $x['give_amount'];
				$spend_per = $x['spend'];
				$save_per = $x['save'];
				$give_per = $x['give'];
				 $genders = $x['gender'];
				if($genders == 'Male')
				 	@$gender = 'his';
				if($genders == 'Female')
					@$gender = 'her';


				  $sql1 = "SELECT * FROM parents WHERE parent_id=$parentid";
				$query1 = mysql_query($sql1);
				$fetch_data = mysql_fetch_assoc($query1);
				 $parentuserid = $fetch_data['parent_user_id'];
				

				$sql2 = "SELECT * FROM users WHERE user_id=$parentuserid";
				$query2 = mysql_query($sql2);
				$fetch_data2 = mysql_fetch_assoc($query2);
				$parentusername = $fetch_data2['user_full_name'];
				$parentemail = $fetch_data2['user_email'];

				$sql3 = "SELECT * FROM users WHERE user_id=$child_user_id";
				$query3 = mysql_query($sql3);
				$fetch_data3 = mysql_fetch_assoc($query3);
				$childname = $fetch_data3['user_full_name'];

				$date= date('Y-m-d');
                 $week_daysnum = $x['allowance_payday'];
                $day = date('d', strtotime( $date));
                 $daynum = date("N", strtotime($day));
                if($daynum == $week_daysnum)
                {


                	$message=' <body style="background-color:#ADD8E6;" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-bottom:0;margin-right:0;margin-left:0;font-family:"Helvetica Neue",Helvetica,Arial,sans-serif;font-size:14px;line-height:1.428571429;color:#333;background-color:#fff;">
  
  <div class="container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-right:15px;padding-left:15px;margin-right:auto;margin-left:auto;">
  
  	<div class="mail-container" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;width:600px;margin-top:20px;margin-bottom:0;margin-right:auto;margin-left:auto;">
  		<div class="mail-header" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#ADD8E6;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;padding-bottom:9px;"><img src="http://dragonbank.com/assets/logo_v2.png" alt="mail-header" width="600" height="87" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;"></div>
  			
  		<div class="mail-content" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;background-color:#fff;background-image:none;background-repeat:repeat;background-position:top left;background-attachment:scroll;position:relative;">
  		 <div class="bg-top" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:absolute;top:0;background-color:transparent;background-image:url(https://i9.createsend1.com/ei/d/87/93A/385/073655/images/mail-gradient-top.png);background-repeat:repeat-x;background-position:0 0;background-attachment:scroll;width:100%;height:35px;"></div>
	  		
	  		<div class="mail-text" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;padding-top:70px;padding-bottom:70px;padding-right:80px;padding-left:80px;color:#666666;">
	  		 
	  			<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;line-height:1.1;font-size:12px;margin-top:0;margin-bottom:5px;margin-right:0;margin-left:0;font-weight:normal!important;"><b>Allowance Reminder:<b><br>Hi '.ucfirst($results['user_full_name']).',</p>
		  		<p style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:0;margin-right:0;margin-left:0;font-size:12px;margin-bottom:5px;line-height:1.6em;">As a reminder, today is the day to pay.'.' '.@$childname.' '.'Monthly allowance. With'.' '.@$childname.' '.'please deposit'.' '.$allowance.' '.'into'.$gender.'Dragon Bank today and remember to record the deposit through your online Dragon Bank account'."<br><br>".@$childnames.' '.'Current Balance Before Today Allowance:'.' '.$allowance."<br><br><br>".'Spend Den:'.' '.$spend_amount."<br>".'Save Den:'.' '.$save_amount."<br>".'Give Den:'.$give_amount."<br><br>".'As a reminder, you and'.' '.@$childnames.' '.'have your Dragon Bank allocation set up as Den Allocation'.' '."<b>".'Save:'.@$save_per.'%'."</b>".' '.' '."<b>".'Spend:'.@$spend_per.'%'."</b>".' '.' '."<b>".'Give:'.@$give_per.'%.'."</b>"."<br><br><br>"."
            Each and every time you complete this process with".' '.@$childname.' '.", she further ingrains these important wealth building disciplines and habits into her routine. Thank you for being so proactive in teaching".' '.@$childname.' '.'about money!</p>
		  		<div class="row" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;margin-top:10px;margin-bottom:10px;margin-right:0;margin-left:0;">
		  			
		  				
		  			<div class="col-xs-9" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;position:relative;min-height:1px;padding-right:15px;padding-left:15px;float:left;width:75%;">
		  			
		  			</div>
		  		</div>
		  		<p>Sincerely,</p>
		  		<font style="font-size:15px">Dragon bank Support team</font><br>

					 			<font style="font-size:13px">Email : <a href="support@dragonbank.com">support@dragonbank.com</a></font><br>
					 			<font style="font-size:13px">Web : <a href="www.dragonbank.com">www.dragonbank.com</a></font>
	  		
	  		</div>
	  		<div class="mail-footer" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;">
		  		
		  		<img src="http://dragonbank.com/assets/img_mailfooter.png" alt="dargon-mail" class="mail-dragon" width="152" height="140" style="-webkit-box-sizing:border-box;-moz-box-sizing:border-box;box-sizing:border-box;border-width:0;vertical-align:middle;position:absolute;right:10px;bottom:6px;z-index:9;">
		  		
	  		</div>
	  		
  		</div>
  	</div>
  
  </div> 

</body>';

            // $msg = '<b>'.'Allowance Reminder:'.'</b>'."<br><br><br>"."Hi".' '.$parentusername.','."<br><br>"."As a reminder, today is the day to pay".' '.@$childname.' '.'Monthly allowance. With'.' '.@$childname.' '.'please deposit'.' '.$allowance.' '.'into'.$gender.'Dragon Bank today and remember to record the deposit through your online Dragon Bank account'."<br><br>".@$childnames.' '.'Current Balance Before Today Allowance:'.' '.$allowance."<br><br><br>".'Spend Den:'.' '.$spend_amount."<br>".'Save Den:'.' '.$save_amount."<br>".'Give Den:'.$give_amount."<br><br>".'As a reminder, you and'.' '.@$childnames.' '.'have your Dragon Bank allocation set up as Den Allocation'.' '."<b>".'Save:'.@$save_per.'%'."</b>".' '.' '."<b>".'Spend:'.@$spend_per.'%'."</b>".' '.' '."<b>".'Give:'.@$give_per.'%.'."</b>"."<br><br><br>"."
            // Each and every time you complete this process with".' '.@$childname.' '.", she further ingrains these important wealth building disciplines and habits into her routine. Thank you for being so proactive in teaching".' '.@$childname.' '. 'about money!'."<br><br>"."Sincerely,"."<br>".' '."The Dragon Bank Support Team"."<br>".'Email: support@dragonbank.com'."<br>".'Web: www.dragonbank.com';
					include 'library.php'; 
					include "classes/class.phpmailer.php";		
					$mail	= new PHPMailer; // call the class 
					$mail->IsSMTP(); 
					$mail->Host = "mail.dragonbank.com"; //Hostname of the mail server
					$mail->Port = 587; //Port of the SMTP like to be 25, 80, 465 or 587
					$mail->SMTPAuth = true; //Whether to use SMTP authentication
					$mail->SMTPSecure = "tls";
					$mail->Username = "support@dragonbank.com"; //Username for SMTP authentication any valid email created in your domain
					$mail->Password = "M8AMvEwNxesq"; //Password for SMTP authentication		
					$mail->SetFrom("support@dragonbank.com"); //From address of the mail
					$mail->Subject = "Dragon Bank Reminder"; //Subject od your mail
					$mail->AddAddress($parentemail); //To address who will receive this email		
					$mail->MsgHTML($message); //Put your body of the message you can place html code here
					$send = $mail->Send();
					if($send) return true;
					else return false;
                }
            }
		}

         function checking_user()
         {
         	$arr= array();
         	if(!empty($_REQUEST['username']))
         	{
         		$username = $_REQUEST['username'];
                 $sql=mysql_query("SELECT * FROM users WHERE user_name='$username'");
                 $count=mysql_num_rows($sql);
                 if($count == 0)
                 {
                 	$arr['response'] = array("msg"=>"success","success"=>"1");
                 }
                 else
                 {
                   $arr['response'] = array("msg"=>"username already exists","success"=>"0");	
                 }
         	}
         	else
         	{
         		$arr['response'] = array("msg"=>"username required","success"=>"0");
         	}
         	echo json_encode($arr);
         }  


	
}

////End of class
	$method = $_REQUEST['method'];
	$obj = new Webservice();
	switch ($method){	
		case 'accesscode_varify':
		echo $obj->accesscode_varify();
		break;
        case 'registration':
		echo $obj->registration();
		break;
		case 'chooseden_allocationtype':
		echo $obj->chooseden_allocationtype();
		break;
		case 'step2':
		echo $obj->step2();
		break;
		case 'step3':
		echo $obj->step3();
		break;
		case 'login':
		echo $obj->login();
		break;
		case 'wishlist':
		echo $obj->wishlist();
		break;
		case 'wishlist_update':
		echo $obj->wishlist_update();
		break;
		case 'wishlist_Add_item':
		echo $obj->wishlist_Add_item();
		break;
		case 'wishlist_remove':
		echo $obj->wishlist_remove();
		break;
		case 'parentMoneyInformation';
		echo $obj->parentMoneyInformation();
		break;
		case 'child_list_using_parentid':
		echo $obj->child_list_using_parentid();
		break;
		case 'amount_show':
		echo $obj->amount_show();
		break;
		case 'amount_deposit_save':
		echo $obj->amount_deposit_save();		
		break;
		case 'amount_withdraw_save':
		echo $obj->amount_withdraw_save();		
		break;
		case 'current_profile':
		echo $obj->current_profile();		
		break;
		case 'show_history':
		echo $obj->show_history();		
		break;
		case 'update_parent_profile':
		echo $obj->update_parent_profile();		
		break;
		case 'update_child_profile':
		echo $obj->update_child_profile();		
		break;
		case 'forget_pass_child':
		echo $obj->forget_pass_child();		
		break;
		case 'forget_pass_parent':
		echo $obj->forget_pass_parent();		
		break;
		case 'history_search':
		echo $obj->history_search();		
		break;
		case 'child_histry_detail':
		echo $obj->child_histry_detail();		
		break;
		case 'setting':
		echo $obj->setting();		
		break;
		case 'show_setting':
		echo $obj->show_setting();		
		break;
		case 'auto_email_weekly':
		echo $obj->auto_email_weekly();		
		break;
		case 'auto_email_monthly':
		echo $obj->auto_email_monthly();		
		break;
		case 'checking_user':
		echo $obj->checking_user();		
		break;
		
		
	
	} 

?>
