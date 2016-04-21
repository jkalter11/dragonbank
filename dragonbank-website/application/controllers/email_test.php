<?php
/*
	child 413 = Brendan's child id - Kaitlyn Wing
	user 746 = Brendan's child user id

	parent 324 = Brendan's parent id
	user 745 = Brendan's user id

	advisor 2 = Todd Peterson

*/

class Email_test extends Application
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		echo "begin";

		$aid = 0;

		$info = array(
			"name" 	=> 'john doe',
			"next"	=> '2014-12-12',
			"cname" => 'ida nakhostin',
			"spa"	=> 10.00,
			"saa"	=> 3.00,
			"gia"	=> 1.00,
			"total"	=> 14.00,
			"freq"	=> 'monthly',
			"aloc"	=> 'something',
			"sex1"	=> "her",
			"sex2"	=> "she",
			"bal"	=> 10000.00,
			"spp"	=> 80.00,
			"sap"	=> 10.00,
			"gip"	=> 10.00,
		);


		//sendNotification("Allowance Reminder", allowanceMsg($info, 2), 'ac.mendoza@gmail.com');
		


		echo "hello";
		exit;
        //$this->load->view("email_template", $this->data);
	}

	function birthdaysadvisors()
	{
		echo "begin<br>---<br>";

		$advisor = array('user_full_name' => 'aubz test');

		$children = array();
		$children[] = (object)array('user_full_name' => 'child one', 'birthday' => '2009-09-03', 'user_email' => 'ac.mendoza@gmail.com');
		$children[] = (object)array('user_full_name' => 'child two', 'birthday' => '2007-09-03', 'user_email' => 'ac.mendoza@gmail.com');
		$children[] = (object)array('user_full_name' => 'third child', 'birthday' => '2005-09-03', 'user_email' => 'ac.mendoza@gmail.com');
		$children[] = (object)array('user_full_name' => 'child last', 'birthday' => '2003-09-03', 'user_email' => 'ac.mendoza@gmail.com');

		sendNotification("Birthday Test", birthdayMessage((object)$advisor, (object)$children), 'ac.mendoza@gmail.com');
		echo "end<br>---<br>";
		//
	}

	function parentChildrenLogin()
	{
		$parent = array('user_full_name' => 'test user', 'advisor_id' => 2);

		$children = array();
		$children[] = array('user_full_name' => 'child one', 'birthday' => '2009-09-03', 'user_email' => 'ac.mendoza@gmail.com');
		$children[] = array('user_full_name' => 'child two', 'birthday' => '2007-09-03', 'user_email' => 'ac.mendoza@gmail.com');
		$children[] = array('user_full_name' => 'third child', 'birthday' => '2005-09-03', 'user_email' => 'ac.mendoza@gmail.com');
		$children[] = array('user_full_name' => 'child last', 'birthday' => '2003-09-03', 'user_email' => 'ac.mendoza@gmail.com');
		sendNotification("Login Test", parentChildrenLogin((object)$parent, $children), 'ac.mendoza@gmail.com');
	}

	function earnedAchievement()
	{
		$this->load->model('challengesclass');

		$challenge = $this->challengesclass->getChallenge(4);

		sendNotification("Achievement Test", earnedStatAchievement(413, 4), 'ac.mendoza@gmail.com');
		sendNotification("Achievement Test", earnedStatAchievementAdvisor(413, 4), 'ac.mendoza@gmail.com');
	}

	function earnedChallenge()
	{
		$this->load->model('challengesclass');

		$challenge = $this->challengesclass->getChallenge(4);

		sendNotification("Challenge Test", completedChallengeAdvisor(413, 1), 'ac.mendoza@gmail.com');
		//sendNotification("Birthday Test", earnedStatAchievementAdvisor(413, 4), 'ac.mendoza@gmail.com');
	}

	function testingEarnedStatThroughHook()
	{
		setAllocationAmountAchievement(4, 413);
	}
}