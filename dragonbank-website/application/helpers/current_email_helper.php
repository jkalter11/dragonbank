<?php

if (!defined('APPPATH'))
	exit('No direct script access allowed');
	
/**
 * helpers/current_email_helper.php
 *
 * Useful functions to get settings email from DB
 *
 * @author		RLR
 * @copyright           Copyright (c) 2013, RL ROSS
 * ------------------------------------------------------------------------
 */

 // Returns the sites email depending on the site's status set in admin section.
 function site_email()
 {
	$CI = & get_instance();
	
	if( ! class_exists('settingsclass') )
	{
		$CI->load->model('settingsclass');
	}
	
	$site_status = $CI->settingsclass->getStatus();
	
	if( (int)$site_status === 1 )
	{
		return $CI->settingsclass->getProEmail();
	}
	else
	{
		return $CI->settingsclass->getDevEmail();
	}
 }

function orderMsg( $info )
{
	$CI = & get_instance();

	$msg = "";

	$msg .= "Name: " 			. $info['fname'] 	. " " . $info['lname'] . "<br />";
	$msg .= "Email: " 			. $info['email'] 	. "<br /><br />";
	$msg .= "Address: "			                    . "<br /><br />";
	$msg .= $info['address']                        . "<br />";
	$msg .= $info['city'] 	                        . ", ";
	$msg .= $info['prov'] 	                        . "<br />";
	$msg .= $info['postal']                         . "<br /><br />";
	$msg .= "Company: " 		. $info['company'] 	. "<br />";
	$msg .= "Phone: " 			. $info['phone'] 	. "<br /><br />";
	$msg .= "Message: <br />"   . $info['message']  . "<br /><br/>";

	$data['name']	= "Dragon Bank Customer Order Information";
	$data['intro'] 	= "======================================";

	$CI->load->vars( $data );

	return $msg;
}
 
function welcomeMsg( $info, $aid = 0 )
{
	$CI = & get_instance();

	if ($aid != 0)
	{
		$CI->load->model('advisorsclass');
		$advisor = $CI->advisorsclass->getAdvisorByID($p->advisor_id);
		if ($advisor !== false)
		{
			$data['advisor'] = (array) $advisor;
		}
	}

	$info['total']  = number_format($info['total'], 2);
	$info['spa']    = number_format($info['spa'], 2);
	$info['saa']    = number_format($info['saa'], 2);
	$info['gia']    = number_format($info['gia'], 2);

	$msg = "";
	$msg .= "
	Thank you for taking the time to create " . $info['cname'] . "'s Dragon Bank profile, " . $info['sex1'] . " is now ready to begin spending, saving, and giving like a Dragon!  Please be sure to read through this entire email to ensure you get the most from your Dragon Bank purchase. 
	<br /><br />
	For your reference, here is the username and password for " . $info['cname'] . " and your account: 
	<br /><br />
	Your Username: " . $info['email'] . " <br />
	Your Password: " . $info['ppass'] . "
	<br /><br />
	" . $info['cname'] . "'s Username: " . $info['cusername'] . "<br>
	" . $info['cname'] . "'s Password: " . $info['cpassword'] . "
	<br><br>
	To access the login page please go to www.dragonbank.com/login, be sure to add this to \"Bookmarks\" on the web browsers of the devices you'll using so that you can easily access it in the future.  The online portion of Dragon Bank was built to work with all devices including smartphones and tablets.  Once you're logged into this account, you will be able to add additional children (Dragon's) to your profile.   
	<br /><br />
	Please remember, the key to spending, saving, and giving like a Dragon is to login in every time " . $info['cname'] . " is making a deposit or withdrawal in " . $info['sex2'] . " Dragon Bank to record and track what's happening, it is simple and easy to do and won’t take more than 5 minutes each time.  
	<br /><br />
	As a recap, based on how you setup this profile, " . $info['cname'] . " currently has a total of $" . $info['total'] . " in " . $info['sex2'] . " Dragon Bank with $".$info['spa']." in spending, $".$info['saa']." allocated for saving and $".$info['gia']." for giving.  
	<br /><br />
	Also, based on how you setup the profile there will be email reminders to pay allowance " . $info['freq'] . " as well as quarterly reminders to put savings into a savings bank account (or investments) and to distribute the giving amount to the charity of " . $info['cname'] . "'s and your choice.
	<br /><br />
	Thanks very much again for your purchase, please contact us below if you have any support or purchase related requests!<br />";
	
	$data['name']	= "Hi " .$info['name']. ",     <br /><br />";

	
	$CI->load->vars( $data );
	
	return $msg;
}

function welcomeMsgChild( $info, $aid = 0 )
{
	$CI = & get_instance();

	if ($aid != 0)
	{
		$CI->load->model('advisorsclass');
		$advisor = $CI->advisorsclass->getAdvisorByID($p->advisor_id);
		if ($advisor !== false)
		{
			$data['advisor'] = (array) $advisor;
		}
	}

	$info['total']  = number_format($info['total'], 2);
	$info['spa']    = number_format($info['spa'], 2);
	$info['saa']    = number_format($info['saa'], 2);
	$info['gia']    = number_format($info['gia'], 2);

	$msg = "";
	$msg .= "
	Thank you for taking the time to create " . $info['cname'] . "'s Dragon Bank profile, " . $info['sex1'] . " is now ready to begin spending, saving, and giving like a Dragon!  Please be sure to read through this entire email to ensure you get the most from your Dragon Bank purchase. 
	<br /><br />
	For your reference, here is the username and password for " . $info['cname'] . "'s account: 
	<br /><br />
	" . $info['cname'] . "'s Username: " . $info['cuser'] . "<br>
	" . $info['cname'] . "'s Password: " . $info['cpass'] . "
	<br><br>
	To access the login page please go to www.dragonbank.com/login, be sure to add this to \"Bookmarks\" on the web browsers of the devices you'll using so that you can easily access it in the future.  The online portion of Dragon Bank was built to work with all devices including smartphones and tablets.  Once you're logged into this account, you will be able to add additional children (Dragon's) to your profile.   
	<br /><br />
	Please remember, the key to spending, saving, and giving like a Dragon is to login in every time " . $info['cname'] . " is making a deposit or withdrawal in " . $info['sex2'] . " Dragon Bank to record and track what's happening, it is simple and easy to do and won’t take more than 5 minutes each time.  
	<br /><br />
	As a recap, based on how you setup this profile, " . $info['cname'] . " currently has a total of $" . $info['total'] . " in " . $info['sex2'] . " Dragon Bank with $".$info['spa']." in spending, $".$info['saa']." allocated for saving and $".$info['gia']." for giving.  
	<br /><br />
	Also, based on how you setup the profile there will be email reminders to pay allowance " . $info['freq'] . " as well as quarterly reminders to put savings into a savings bank account (or investments) and to distribute the giving amount to the charity of " . $info['cname'] . "'s and your choice.
	<br /><br />
	Thanks very much again for your purchase, please contact us below if you have any support or purchase related requests!<br />";
	
	$data['name']	= "Hi " .$info['name']. ",     <br /><br />";
	
	$CI->load->vars( $data );
	
	return $msg;
}

function quarterlyMsg( $info, $aid = 0)
{
	$CI = & get_instance();

	if ($aid != 0)
	{
		$CI->load->model('advisorsclass');
		$advisor = $CI->advisorsclass->getAdvisorByID($p->advisor_id);
		if ($advisor !== false)
		{
			$data['advisor'] = (array) $advisor;
		}
	}

	$msg = "";
	$msg .= "
	This email is to remind you to take the $" .$info['saa']. " " .$info['cname']. " has allocated for savings in ".$info['sex1']." Dragon bank and to deposit it into a high-interest savings account or with a financial advisor.  Also, " .$info['cname']. " has $" .$info['gia']. " in ".$info['sex1']." Dragon Bank set aside for a charity.
	<br /><br />
	Please be sure to take the time to invest the savings and to give to the charity of you and your child’s choice!  These activities are fundamental steps in practicing the way of the Dragon and with repetition, can be building blocks for the foundation of your child’s financial future.<br />";

	$data['name']	= "Hi " .$info['name']. ",     <br /><br />";

	$CI->load->vars( $data );

	return $msg;
}

function allowanceMsg($info, $aid = 0)
{
	$CI = & get_instance();

	if ($aid != 0)
	{
		$CI->load->model('advisorsclass');
		$advisor = $CI->advisorsclass->getAdvisorByID($aid);
		if ($advisor !== false)
		{
			$data['advisor'] = (array) $advisor;

		}
	}

	$t 	= $info['total'];

	$info['spp'] 	= "$" . number_format($info['spp'], 2);	// Spending Portion.
	$info['sap'] 	= "$" . number_format($info['sap'], 2);	// saving Portion.
	$info['gip'] 	= "$" . number_format($info['gip'], 2);	// Giving Portion.
	$info['total']  = "$" . number_format($t, 2);			// Total Amount.

	// Sets the formatting to no decimals if the value is a whole number.
	$info['spa'] = ($info['spa'] == ceil( $info['spa'] ))? (int)$info['spa'] : number_format($info['spa'], 2);
	$info['saa'] = ($info['saa'] == ceil( $info['saa'] ))? (int)$info['saa'] : number_format($info['saa'], 2);
	$info['gia'] = ($info['gia'] == ceil( $info['gia'] ))? (int)$info['gia'] : number_format($info['gia'], 2);

	$msg = "";
	$msg .= " As a reminder today is the day to pay " .$info['cname']. "'s " . $info['freq'] . " allowance for chores completed around the house.  With " .$info['cname']. ", please deposit " .$info['total']. " into " .$info['sex1']. " Dragon Bank today and remember to record the deposit through your online Dragon Bank account.<br/><br/>

" .$info['cname']. "'s Current Balance Before Today’s Allowance: $" .$info['bal']. "<br/>
Spending Portion: " .$info['spp']. "<br/>
Saving Portion: " .$info['sap']. "<br/>
Giving Portion: " .$info['gip'] . "
	<br /><br />
	As a reminder, you and " .$info['cname']. " have your Dragon Bank earnings allocation setup as '". $info['aloc'] ."' Spend " . $info['spa'] . "%, Save ".$info['saa']."%, Give ".$info['gia']."%.<br /><br/>

	Each and every time you complete this process with " .$info['cname']. ", " .$info['sex2']. " further ingrains these important wealth building disciplines and habits into " .$info['sex1']. " routine.  Thank you for following the Way Of The Dragon! ";

	$data['name']	= "Hi " .$info['name']. ",     <br /><br />";
	$CI->load->vars( $data );

	return $msg;
}

function forgotPasswordMsg( $temp, $name )
{
	$CI = & get_instance();
	
	$msg = "";
	$msg .= "We have received your request to reset your password. Please log in with this temporary password: $temp    <br /><br />";
	$msg .= BASE_URL."login    <br /><br />";
	$msg .= "If you did not request this information, we apologize for the error. Another member may have inadvertently entered the incorrect Member Name on the Password Recovery form, which prompted this email to be sent.     <br /><br />";
	
	$data['intro'] 	= "Great money habits learned early, make a big difference in your child's life.";
	$data['name']	= "Dear, $name     <br /><br />";
	
	$CI->load->vars( $data );
	
	return $msg;
}

function verifyEmailMsg( $key )
{
	$CI = & get_instance();
	
	$msg = "Please click the link below to verify your new email address    <br /><br />";
	
	$msg .= BASE_URL."verify_email/".urlencode( $key ); 
	
	$data['intro'] = "Great money habits learned early, make a big difference in your child's life.";
	$CI->load->vars($data);
	
	return $msg;
}


function sendContactEmail($post, $isAdvisor = true)
{
	$CI = &get_instance();
	$fullname = $CI->session->userdata('user_name');

	if ($isAdvisor)
	{
		$msg = "An Advisor has completed the Contact Us/Help Form with the following information:<br><br>\n";
	}
	else
	{
		$msg = "A Parent has completed the Contact Us/Help Form with the following information:<br><br>\n";
	}
	
	if ($isAdvisor)
	{
		if (isset($post['contact1']))
		{
			$msg .= "- How I can add the Enriched Academy Smart Start for Teens &amp; Young Adults to my Program<br>\n";
		}

		if (isset($post['contact2']))
		{
			$msg .= "- How the Enriched Academy Support team can help me grow my business<br>\n";
		}

		if (isset($post['contact3']))
		{
			$msg .= "- How to get involved with the Enriched Academy Advisor Referral Program<br>\n";
		}

		if (isset($post['contact4']))
		{
			$msg .= "- How to use My Dashboard to ensure my program is effective<br>\n";
		}
	}
	else
	{
		if (isset($post['contact1']))
		{
			$msg .= "- How I can add the Enriched Academy Smart Start for Teens &amp; Young Adults to my Program<br>\n";
		}

		if (isset($post['contact2']))
		{
			$msg .= "- RESPs or TFSAs<br>\n";
		}

		if (isset($post['contact3']))
		{
			$msg .= "- Options to help my child save or invest more effectively<br>\n";
		}

		if (isset($post['contact4']))
		{
			$msg .= "- I have questions on using the Dragon Bank effectively<br>\n";
		}
	}

	if (isset($post['contact-other']) && !empty($post['contact-other']))
	{
		$msg .= "Other:<br>\n" . $post['contact-other'] . "<br>\n";
	}

	if ($isAdvisor)
	{
		$CI->load->model('advisorsclass');
		$typeData = $CI->advisorsclass->getAdvisorByID($CI->session->userdata('type_id'));

		$msg .= "<br>\nPlease contact this advisor for assistance.<br><br>\n";

		$msg .= $fullname . "<br>\n" . $typeData->company . "<br>\n";

		if (!empty($typeData->cell))
		{
			$msg .= $typeData->cell . "<br>\n";
		}
		else
		{
			$msg .= $CI->session->userdata("phone") . "<br>\n";
		}

		$msg .= $CI->session->userdata('name_email');
	}
	else
	{
		$msg .= "Please contact this parent for assitance.<br><br>\n";
		$msg .= $fullname . "<br>\n" . $CI->session->userdata('phone') . "<br>\n" . $CI->session->userdata('name_email');
	}

	return $msg;
}

function sendContactPublicEmail($post)
{
	$CI = &get_instance();

	$msg = "A user has completed the Contact Us/Help Form with the following information:<br><br>\n";
	
	$msg .= "Name: " . $post['contact_name'] . "<br>\n";
	$msg .= "Email: " . $post['contact_email'] . "<br>\n";

	if (isset($post['contact_number']) && !empty($post['contact_number']))
	{
		$msg .= "Contact Number: " . $post['contact_number'] . "<br>\n";
	}

	$msg .= "<br>Message:<br>\n" . $post['contact_message'] . "<br>\n";

	$data['conclusion'] = '';
	$CI->load->vars($data);

	return $msg;
}

function sendQuestionsIdeas($post)
{
	$CI = &get_instance();
	$CI->load->model('advisorsclass');
	$typeData = $CI->advisorsclass->getAdvisorByID($CI->session->userdata('type_id'));

	$advisor = $CI->session->userdata('user_name');



	$msg = "An Advisor has completed the Questions or Ideas Form with the following information:<br><br>\n";

	if (isset($post['questions-ideas']))
	{
		$msg .= $post['questions-ideas'] . "<br><br>\n";
	}

	$msg .= "Please contact this advisor for assistance.<br><br>\n";

	$msg .= $advisor . "<br>\n" . $typeData->company . "<br>\n";

	if (!empty($typeData->cell))
	{
		$msg .= $typeData->cell . "<br>\n";
	}
	else
	{
		$msg .= $CI->session->userdata("phone") . "<br>\n";
	}

	$msg .= $CI->session->userdata('name_email');


	return $msg;
}

function birthdayMessage($advisor, $children)
{
	$CI = & get_instance();

	$data['name'] = "Hi " . $advisor->user_full_name . ",     <br /><br />";

	$msg = '';
	$msg .= "This email is to remind you of your client birthdays happening this month:<br /><br />";

	foreach ($children as $c)
	{
		$from = new DateTime($c->birthday);
		$to = new DateTime('today');

		$age = $from->diff($to)->y;

		$msg .= $c->user_full_name . ' - Age: ' . $age . ' - Birthday: ' . $c->birthday . " - " . $c->user_email . "<br>";
	}

	$msg .= "<br>It may be a good idea to touch base and wish them a Happy Birthday!<br><br>\n";

	$CI->load->vars($data);

	return $msg;
}

function advisorLogin($advisor)
{
	$CI = & get_instance();

	$data['name'] = "Hi " . $advisor->user_full_name . ",     <br /><br />";

	$msg = '';
	$msg .= "If you are interested in learning more about how we can help you drive the growth of your business, please contact our support team to arrange a call or simply <a href=\"http://www.dragonbank.com/advisors/contact\">CLICK HERE</a>.  We would like to share some great tips and tactics to help in your success. In three simple steps we will help you turn this into a powerful business development and client service tool!<br /><br />";

	$CI->load->vars($data);

	return $msg;
}

function parentChildrenLogin($p, $children)
{
	$CI = & get_instance();

	$CI->load->model('advisorsclass');
	$advisor = $CI->advisorsclass->getAdvisorByID($p->advisor_id);
	if ($advisor !== false)
	{
		$data['advisor'] = (array) $advisor;
	}

	$childrenText = '';
	$msg = "This is a quick reminder to let you know that we have recently added some tremendous new features, activities and challenges to help kids learn how to save and manage their money effectively.<br /><br />\n";

	for ($i = 0; $i < count($children); ++$i)
	{
		if ($i == count($children) - 1)
		{
			$childrenText .= 'and ';
		}
		$childrenText .= reset(explode(" ", $children[$i]['user_full_name'])) . ", ";
	}

	$childrenText = rtrim($childrenText, ', ');

	$msg .= $childrenText;

	$msg .= " will have a lot of fun with this!<br><br>\n";

	$msg .= "In fact, more and more kids today are saving with Dragon Bank, donating to charities and learning valuable lessons to help ensure they are prepared for a lifetime of great money habits.<br><br>\n";
	$msg .= "If you need any assistance learning more about Dragon Bank, or how to use this system to help teach your kids about money management, please don't hesitate to contact us at <a href=\"mailto:support@dragonbank.com\">support@dragonbank.com</a>.<br><br>\n";
	$msg .= "Log in by <a href=\"http://www.dragonbank.com/login\">CLICKING HERE</a><br><br>\n";

	$data['name']	= "Hi " . $p->user_full_name . ",<br /><br />";

	$CI->load->vars( $data );

	return $msg;
}

function advisorParentChildLogin($advisor, $p, $children)
{
	$CI = & get_instance();

	$data['name'] = "Hi " . $advisor->user_full_name . ",<br /><br />";
	$childrenText = '';

	$msg = "This is a quick reminder that you gave the " . end(explode(' ' , $p->user_full_name)) . " family a Dragon Bank to ";

	for ($i = 0; $i < count($children); ++$i)
	{
		if ($i == count($children) - 1)
		{
			$childrenText .= 'and ';
		}
		$childrenText .= reset(explode(" ", $children[$i]['user_full_name'])) . ", ";
	}

	$childrenText = rtrim($childrenText, ', ');

	$msg .= $childrenText;

	$msg .= " start to learn the importance of saving money early in their life.<br /><br />";

	$msg .= "It is a great time to call them and let them know that you were thinking about " . $childrenText . ", and that you want to ensure their child is given every opportunity possible to get them on a path towards real financial awareness as they get older.<br><br>\n";

	$msg .= "Let them know to Log into Dragon Bank, as there are some fun activities and challenges that will help teach valuable money lessons that will last a lifetime!<br><br>\n";


	$CI->load->vars($data);

	return $msg;
}

function sendColleagueEmail($post)
{
	$CI = &get_instance();
	$advisor = $CI->session->userdata('user_name');

	$data['name'] = 'Hi';

	if (isset($post['name']) && !empty($post['name']))
	{
		$data['name'] .= ' ' . $post['name'];
	}

	$data['name'] .= ",<br><br>\n";

	$msg = '';
	$msg .= "I have started using an incredible program designed to help attract new prospects, increase the value I bring to my clients and their families, and even build new relationships with 2nd generation clients.<br><br>";
	$msg .= "I thought you would find this helpful too.<br><br>";

	$msg .= 'If you want to learn more, <a href="http://www.dragonbank.com">CLICK HERE</a> to check it out.' . "<br><br>\n";

	$data['conclusion'] = 'Sincerely,' . "<br>\n" . $advisor;

	$CI->load->vars($data);

	return $msg;

}

function sendOrderEmail($post)
{
	$CI = &get_instance();
	$CI->load->model('advisorsclass');
	$typeData = $CI->advisorsclass->getAdvisorByID($CI->session->userdata('type_id'));
	$advisor = $CI->session->userdata('user_name');

	$msg = "An Advisor has completed the Order Form with the following information:<br><br>\n";

	$msg .= "Credit Card Type: " . $post['cctype'] . "<br><br>\n";

	if ($post['optionsRadios'] == 'option1')
	{
		$msg .= '- Order 12 more Banks: $219.99';
	}
	else if ($post['optionsRadios'] == 'option2')
	{
		$msg .= '- Order 24 more Banks: $359.99';
	}
	else
	{
		$msg .= '- Order 60 more Banks: $779.99';
	}

	$msg .= "<br><br>\n";

	$msg .= "Please contact this advisor for assistance.<br><br>\n";

	$msg .= $advisor . "<br>\n" . $typeData->company . "<br>\n";

	if (!empty($typeData->cell))
	{
		$msg .= $typeData->cell . "<br>\n";
	}
	else
	{
		$msg .= $CI->session->userdata("phone") . "<br>\n";
	}

	$msg .= $CI->session->userdata('name_email');

	return $msg;

}

function sendTellAFriend($post)
{
	$CI = &get_instance();

	$data['name'] = 'Hi ' . $post['full_name'] . ",<br><br>\n";

	$msg = '';
	$msg .= "I found this INCREDIBLE way to help kids learn about money!  It is a great way to start saving money and to learn some important lessons that will make sure you start to SAVE, and SPEND money properly.<br><br>\n
I thought you would REALLY like this too!<br><br>\n
If you want to learn more, " . '<a href="www.dragonbank.com">CLICK HERE</a>' . " to check it out.";


	$data['conclusion'] = 'Sincerely,<br>' . $CI->session->userdata('user_name') . "<br>\n";
	$CI->load->vars($data);
	return $msg;
}

function advisorSignup($user, $advisor)
{
	$CI = &get_instance();

	$msg = '';

	$data['name'] = "CONGRATULATIONS " . $user['user_full_name'] . "<br><br>\n";

	$msg .= "Your personalized Advisor Platform is now activated and you will now be able to leverage Enriched Academy and Dragon Bank to automatically connect and help educate both new prospects and existing clients.<br><br>\n";
	$msg .= "To Log IN and view Your Dashboard:<br><br>\n";
	$msg .= "- go to <a href=\"http://www.dragonbank.com\">www.dragonbank.com</a><br>\n";
	$msg .= "- click Log In<br>\n";
	$msg .= "Enter your Username: " . $user['user_email'] . "<br>\n";
	$msg .= "Enter your Password: " . $user['pwForEmail'] . "<br><br>\n";

	$msg .= "This is a GREAT step you are taking to add even more value to your client relationships and really making a difference in the financial knowledge of others. If you need any help or advice, just <a href=\"http://www.dragonbank.com/advisors/contact\">CLICK HERE</a> and we will be happy to help!<br><br>\n";

	$CI->load->vars($data);

	return $msg;
}

function earnedStatAchievement($childid, $achievementid)
{
	$CI = &get_instance();
	$CI->load->model(array('childrenclass', 'advisorsclass'));
	$child = $CI->childrenclass->getChildByID($childid);

	$advisor = $CI->advisorsclass->getAdvisorByID($child->advisor_id);
	if ($advisor !== false)
	{
		$data['advisor'] = (array) $advisor;
	}

	$CI->db->select('title, icon');
	$CI->db->where('id', $achievementid);
	$result = $CI->db->get('achievements');
	$achievement = $result->row();
	//if ()


	$msg = '';

	$data['name'] = "Dear " . $child->parentname . ",<br><br>\n";

	$msg = "This is just a quick note to say CONGRATULATIONS to " . reset(explode(' ', $child->user_full_name)) . ".<br><br>\n";

	$msg .= reset(explode(' ', $child->user_full_name)) . " just reached a great milestone <strong>" . $achievement->title . "</strong> and should be really proud of their efforts.<br><br>\n";

	$msg .= "We hope more kids take the time like " . reset(explode(' ', $child->user_full_name)) . " to learn the importance of saving money so early in life. If " . reset(explode(' ', $child->user_full_name)) . " keeps this saving like this, they are really setting themselves up for a great financial future.<br><br>\n";
	
	$msg .= '<center><img src="' . ACH_IMG_PATH . $achievement->icon . '" style="width: 64px; display: block;">' . "</center><br><br>\n";

	if ($advisor !== false)
	{
		$msg .= "Your advisor may have some ways to help get that money really working for " . reset(explode(' ', $child->user_full_name)) . ". It may be worth a quick call to find out.<br><br>\n";
	}

	$msg .= "Congratulations again!<br><br>\n";

	$CI->load->vars($data);

	return $msg;
}


function earnedStatAchievementAdvisor($childid, $achievementid)
{
	$CI = &get_instance();
	$CI->load->model(array('childrenclass', 'advisorsclass'));
	$child = $CI->childrenclass->getChildByID($childid);

	$advisor = $CI->advisorsclass->getAdvisorByID($child->advisor_id);
	if ($advisor !== false)
	{
		$data['advisor'] = (array) $advisor;
	}

	$CI->db->select('title, icon');
	$CI->db->where('id', $achievementid);
	$result = $CI->db->get('achievements');
	$achievement = $result->row();

	$msg = "You gave a Dragon Bank to the " . end(explode(' ' , $child->parentname)) . " family and they are really putting it to great use.<br><br>\n";

	$msg .= "Their child, " . reset(explode(' ', $child->user_full_name)) . ", just reached a great milestone <strong>" . $achievement->title . "</strong> and earned a Badge for their efforts.<br><br>\n";

	$msg .= "This is a great time to call or email " . reset(explode(' ' , $child->parentname)) . " at <a href=\"" . $child->user_email . "\">" . $child->user_email . "</a> to let them know that you were notified of this achievement, and that you have some great ideas to help get that money working even harder for " . reset(explode(' ', $child->user_full_name)) . ". Let them know that you want to arrange a call or meeting to discuss.<br><br>\n"; 

	$data['name'] = "Dear " . $advisor->user_full_name. ", <br><br>\n";

	$CI->load->vars($data);

	return $msg;
}

function completedChallenge($childid, $challengeid)
{

	$CI = &get_instance();
	$CI->load->model(array('childrenclass', 'advisorsclass', 'challengesclass'));
	$child = $CI->childrenclass->getChildByID($childid);

	$advisor = $CI->advisorsclass->getAdvisorByID($child->advisor_id);
	if ($advisor !== false)
	{
		$data['advisor'] = (array) $advisor;
	}

	$challenge = $CI->challengesclass->getChallenge($challengeid);

	$data['name'] = "Dear " . $child->parentname . ",<br><br>\n";

	$msg = 'CONGRATULATIONS! ' . reset(explode(' ', $child->user_full_name)) . " is being very proactive in learning about controlling their money!<br><br>\n";
	$msg .= reset(explode(' ', $child->user_full_name)) . " completed the <strong>" . $challenge->achievement_title . "</strong> and has earned their Badge. To award that badge, please <a href=\"http://www.dragonbank.com\">CLICK HERE</a> to log in to Dragon Bank and comfirm the challenge is now complete.<br><br>\n";
	$msg .= "Once you log in, simply go to <strong>" . $challenge->title . "</strong> Challenge page and click \"Complete\". Dragon Bank will instantly award them their Badge! This is a big effort! Don’t forget to share their success on Facebook!<br>\n";
	$msg .= '<center><img src="' . ACH_IMG_PATH . $challenge->icon . '" style="width: 64px; display: block;">' . "</center><br>\n";

	$CI->load->vars($data);
	return $msg;
}


function completedChallengeAdvisor($childid, $challengeid)
{
	$CI = &get_instance();
	$CI->load->model(array('childrenclass', 'advisorsclass', 'challengesclass'));
	$child = $CI->childrenclass->getChildByID($childid);

	$advisor = $CI->advisorsclass->getAdvisorByID($child->advisor_id);
	if ($advisor !== false)
	{
		$data['advisor'] = (array) $advisor;
	}

	$challenge = $CI->challengesclass->getChallenge($challengeid);

	$data['name'] = "Dear " . $advisor->user_full_name . ",<br><br>\n";

	$msg = "You gave a Dragon Bank to the " . end(explode(' ', $child->parentname)) . " family and they are really putting it to great use.<br><br>\n"; 

	$msg .= "Their child, " . reset(explode(' ', $child->user_full_name)) . ", just completed the <strong>" . $challenge->achievement_title . "</strong> and earned a Badge for their efforts.<br><br>\n";

	$msg .= "This is a great time to call or email " . reset(explode(' ' , $child->parentname)) . " at <a href=\"" . $child->user_email . "\">" . $child->user_email . "</a> to let them know that you were notified of this achievement, and that it is GREAT to see parents helping kids learn the importance of money and money management so early in life!<br><br>\n";

	$CI->load->vars($data);
	return $msg;
}





function sendNotification( $subject, $msg, $email, $mailtype = "html")
{
	
	$CI = & get_instance();
	
	$CI->load->model('settingsclass');
	$CI->load->library('email');
	
	$site_email = site_email();
	
	if( $CI->settingsclass->getStatus() == 2 )
	{
		$email = $site_email;
	}

	if (empty($msg))
	{
		return false;
	}
	
	$data['content'] 	= $msg; 
	$config['mailtype'] = $mailtype;
	
	$CI->email->initialize($config);	// This sends, in this case, the mailtype preference. 
	
	$CI->email->from( "Dragon Bank Support Team <support@dragonbank.com>" );
	$CI->email->to( $email ); 
	$CI->email->cc(''); 
	$CI->email->bcc('kaushleshsingh@gmail.com;susan@enrichedacademy.com;todd@enrichedacademy.com');
	$CI->email->subject( $subject );
	$CI->email->message( $CI->parser->parse('v2/email_template', $data, TRUE));
	
	return $CI->email->send();
}
