<?php
/**
 * how.php Controller Class.
 */
class Challenges extends Application {

	function __construct(){
		parent::__construct();
		$this->load->model(array('childrenachievementclass', 'challengesclass', 'childrenclass', 'challengestepsclass', 'challengelessonsclass'));
	}
	
	function index()
	{
		if (!isset($_GET['id']) || !is_numeric($_GET['id']))
		{
			header('Location: /new/profile');
			exit;
		}

		$challenge = $this->challengesclass->getChallenge($_GET['id']);
		if ($challenge == false)
		{
			header('Location: /new/profile');
			exit;
		}

		// if parent
		if ($this->session->userdata('user_group') == 2)
		{
			$child = $this->childrenclass->getChildInfoByParent($this->session->userdata('type_id'));
			
			foreach ($child as &$c)
			{
				$c['achievementStatus'] = $this->childrenachievementclass->getStatusOnChallengeID($_GET['id'], $c['child_id']);
			}

			$this->vars['child'] = $child;
			
			$this->data['pagebody'] = 'v2/challenges';
		}
		else
		{
			$child = $this->session->userdata('typeData');
			$this->load->vars($child);
			$this->vars['achievementStatus'] = $this->childrenachievementclass->getStatusOnChallengeID($_GET['id'], $this->session->userdata('type_id'));

			$this->data['pagebody'] = 'v2/challenges_child';
		}

		if (isset($_POST['complete']))
		{
			$typeData = $this->session->userdata('typeData');

			sendNotification("Dragon Bank - " . $this->session->userdata('user_name') . " has completed the " . $challenge->title . " Challenge!", completedChallenge($_POST['child_id'], $_POST['challenge']), $typeData['user_email']);
			$this->childrenachievementclass->setAchievementOnChallengeID($_POST['challenge'], $_POST['child_id']);
			set_message("<strong>Success</strong> Your challenge has been marked complete. Your parent will need to approve your challenge.", 'alert-success');
			header('location: /new/profile/challenges?id=' . $_GET['id']);
			exit;
		}

		if (isset($_POST['confirm_complete']))
		{
			$this->childrenachievementclass->setConfirmOnChallengeID($_POST['challenge'], $_POST['child_id']);

			$this->load->model(array('advisorsclass'));

			$advisor = $this->advisorsclass->getAdvisorByParentID($this->session->userdata('type_id'));	

			if ($advisor !== false)
			{
				$child = $this->childrenclass->getChildByID($_POST['child_id']);
				if ($_POST['child_id'] == 413)
				{
					$advisor->user_email = 'ac.mendoza@gmail.com';
				}
				sendNotification("Dragon Bank - " . $child->user_full_name . " has completed the " . $challenge->title . " Challenge!", completedChallengeAdvisor($_POST['child_id'], $_POST['challenge']), $advisor->user_email);
			}

			set_message("<strong>Success</strong> Your child has unlocked this achievement!", 'alert-success');
			header('location: /new/profile/challenges?id=' . $_GET['id']);
			exit;
		}

		

		$steps = $this->challengestepsclass->getStepsByChallengeID($_GET['id']);

		$lessons = $this->challengelessonsclass->getLessonsByChallengeID($_GET['id']);
		
		
		$this->vars['challengeID'] = $_GET['id'];
		$this->vars['challenge'] = $challenge;
		$this->vars['steps'] = $steps;
		$this->vars['lessons'] = $lessons;

		
		$this->data['pagetitle'] 	= 'Challenges';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Dragon Bank Purchase Profile Setup Enter Access Code Create Profile Spend Save Give Record Deposits withdrawls';
		//$data["addCSS"] = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		//$data["addJS"]	= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		$this->load->vars($this->vars);
		$this->render();
	}
}

/* End of file how.php */
/* Location: ./application/controllers/how.php */
