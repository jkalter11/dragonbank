<?php

class Allowance_cron extends Application {

	function __construct()
	{
		parent::__construct();

		$this->load->model(array("childrenclass", "historyclass", "parentsclass", "advisorsclass", "usertrackingclass"));
	}

	/**
	 * Deposits child's allowance and saves history.
	 *
	 * @param $total: 	Total amount to deposit.
	 * @param $sp		Spend percentage.
	 * @param $sa		Save percentage.
	 * @param $gi		Give percentage.
	 * @param $cid		Child's id.
	 */
	private function deposit( $total, $sp, $sa, $gi, $cid )
	{
		$cc = $this->childrenclass;

		// total amount.
		$total = (float)$total;

		// Percent amount
		$money = (float)($total * 0.01);

		// Sets the correct amount based on default allocation set.
		$sp = (float)$money * (float)$sp;
		$sa = (float)$money * (float)$sa;
		$gi = (float)$money * (float)$gi;

		$where = array( "child_id" => $cid );

		if( $sp > 0.00 )
		{
			$cc->update($where, "spend_amount", "spend_amount+$sp");
		}

		if( $sa > 0.00 )
		{
			$cc->update($where, "save_amount", "save_amount+$sa");
		}

		if( $gi > 0.00 )
		{
			$cc->update($where, "give_amount", "give_amount+$gi");
		}

		if( $total > 0 )
		{
			$cc->update($where, "balance", "balance+$total");
		}

		$this->saveHistory( (float)$total, $sp, $sa, $gi, $cid );
	}

	/**
	 * Saves child's deposit history.
	 *
	 * @param $total:	Total amount of deposit.
	 * @param $sp		Spend amount of deposit.
	 * @param $sa		Save amount of deposit.
	 * @param $gi		Give amount of deposit.
	 * @param $cid		Child's id.
	 */
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
		$rec['desc'] 				= "Allowance Payday";
		$rec['credit'] 				= (float)$total;
		$rec['transaction']			= "Deposit";

		save_or_update("historyclass", "history_id", "", $rec);
	}

	/**
	 * Sends email to all user's that set their settings to receive allowance reminders.
	 *
	 * @param $cid:		Child's id.
	 * @param $pid:		Parent's id.
	 * @param $date:	date of transaction.
	 * @param $freq:	Allowance Frequency.
	 * @param $c:		The array containing child's data.
	 */
	public function allowanceReminder( $cid, $pid, $date, $freq, $c)
	{
		$p 		= $this->parentsclass->getEmailName( $pid );
		$uid 	= $this->childrenclass->getOneWhere("child_id", $cid, "child_user_id");
		$cname	= reset(explode(" ", $this->usersclass->getOneWhere("user_id", $uid, "user_full_name") ) );
		$sex	= $c['gender'];
		$aid = 0;

		$this->db->select('advisor_id');
		$this->db->where('parent_id', $pid);
		$result = $this->db->get('parents');
		$r = $result->row();
		if (!empty($r->advisor_id))
		{
			$aid = $r->advisor_id;
		}


		// If the parent wants a reminder sent.
		if( (int)$p['allowance_reminder'] === 1 )
		{
			$info = array(
				"name" 	=> reset(explode(" ", $p['user_full_name'])),
				"next"	=> date("F jS, Y", strtotime($date)),
				"cname" => $cname,
				"spa"	=> (float)$c['spend'],
				"saa"	=> (float)$c['save'],
				"gia"	=> (float)$c['give'],
				"total"	=> (float)$c['allowance'],
				"freq"	=> $freq,
				"aloc"	=> $c['allocation_name'],
				"sex1"	=> ($sex == "Male")? "his" : "her",
				"sex2"	=> ($sex == "Male")? "he" : "she",
				"bal"	=> $c['balance'],
				"spp"	=> $c['spend_amount'],
				"sap"	=> $c['save_amount'],
				"gip"	=> $c['give_amount'],
			);

			sendNotification("Allowance Reminder", allowanceMsg($info, $aid), $p['user_email']);
		}
	}

	public function birthdayReminders($advisors)
	{
		foreach ($advisors as $a)
		{
			$children = $this->childrenclass->getChildrenWithBirthdaysByAdvisorID($a->id);

			if (count($children))
			{
				sendNotification("Birthdays for the month of " . date("F, Y"), birthdayMessage($a, $children), $a->user_email);
			}
		}
	}

	public function loginReminders($advisors)
	{
//		$query = "
//			SELECT id, user_id, DATEDIFF(NOW(), FROM_UNIXTIME(logged_in)) days, logged_in, logged_out
//			FROM user_tracking
//			WHERE user_id = ?
//			AND DATEDIFF(NOW(), FROM_UNIXTIME(logged_in)) = 45
//			ORDER BY logged_in DESC
//			LIMIT 1
//		";

        $query = "
			SELECT id, user_id, DATEDIFF(NOW(), FROM_UNIXTIME(logged_in)) as days, logged_in, logged_out
			FROM user_tracking
			WHERE user_id = ?
			ORDER BY logged_in DESC
			LIMIT 1
		";//edited by dennis


		foreach ($advisors as $a)
		{
//            $result = $this->db->query($query, array($a->user_id));

			$result = $this->db->query($query, array($a->user_id))->result();//edited by dennis
//            if ($result->num_rows() > 0)
            if (count($result) > 0 && $result[0]->days == '45')//edited by dennis
			{
				//

				sendNotification("Dragon Bank - Advisor Inactivity", advisorLogin($a), $a->user_email);
			}

		}

		$parents = $this->parentsclass->getActiveParents();
		if (count($parents))
		{
			foreach ($parents as $p)
			{
				$parentInactive = false;
				$childInactive = false;

				$childrenForEmail = array();
//                $result = $this->db->query($query, array($p->user_id));
				$result = $this->db->query($query, array($p->user_id))->result();//edited by dennis

//						if ($result->num_rows() > 0)
                if (count($result) > 0 && $result[0]->days == '45')//edited by dennis
				{
					$parentInactive = true;
				}

				$children = $this->childrenclass->getChildInfoByParent($p->parent_id);

				if (count($children))
				{
					foreach ($children as $c)
					{
						$childrenForEmail = $c;

//						$result = $this->db->query($query, array($c['user_id']));
                        $result = $this->db->query($query, array($c->user_id))->result();//edited by dennis

//						if ($result->num_rows() > 0)
                        if (count($result) > 0 && $result[0]->days == '45')//edited by dennis
						{
							$childInactive = true;
                            //$a = $this->advisorsclass->getAdvisorByID($p->advisor_id);//added by dennis
							//sendNotification("Dragon Bank - Parent/Children Inactivity", advisorLogin($a), $a->user_email);
						}
					}
				}

				if ($parentInactive || $childInactive)
				{

//					sendNotification("Dragon Bank - Parent/Children Inactivity", parentChildrenLogin($p, $childrenForEmail), $p->user_email);
                    //edited by dennis
                    sendNotification("Dragon Bank - Parent/Children Inactivity", parentChildrenLogin($p, $children), $p->user_email);
					if ($p->advisor_id != NULL)
					{
						$advisor = $this->advisorsclass->getAdvisorByID($p->advisor_id);
//						sendNotification("Dragon Bank - Parent/Children Inactivity", advisorParentChildLogin($advisor, $p, $childrenForEmail), $advisor->user_email);
                        //edited by dennis
                        sendNotification("Dragon Bank - Parent/Children Inactivity", advisorParentChildLogin($advisor, $p, $children), $advisor->user_email);

                    }
				}

			}
			
		}
		



	}

	function index()
	{

		$c 		= $this->childrenclass->getAllowances();		// Only children with allowances > 0.00 are returned.
		$today 	= date("Y-m-d");								// Today's date
		$dayNum = date('d');
		$time 	= strtotime( $today );							// Today's date timestamp format.
		$mdate 	= date("Y-m-d", strtotime("+1 month", $time));	// Today's date +1 month.
		$wdate 	= date("Y-m-d", strtotime("+1 week", $time));	// Today's date +1 week.
		$advisors = $this->advisorsclass->getActiveAdvisors();

		if (count($advisors))
		{
			// do birthdays
			if ($dayNum == 1)
			{
				$this->birthdayReminders($advisors);
			}

			$this->loginReminders($advisors);
		}

		foreach($c as $k => $v)
		{
			$cid = (int)$v['child_id'];		// Child id.
			$pid = (int)$v['parent_id'];	// Parent id.
			$apd = $v['allowance_paydate']; // Allowance Pay Date.

			$freq = strtolower($v['allowance_frequency']); // Either week or month.

			if( $freq == "month" )
			{
				$date 	= $mdate;
				$fre	= "Monthly";
			}
			else
			{
				$date 	= $wdate;
				$fre	= "Weekly";
			}

			// If paydate has not been set, we want to set it now.
			if( ! preg_match("/^\d{4}[-]\d{2}[-]\d{2}?/", $apd ) )
			{
				$this->childrenclass->updatePaydate( $cid, $date );

				continue;
			}

			// Only children paid on this day of the week are accepted.
			if( $apd == $today )
			{
				// Update children's bank accounts and save to history.
				$this->deposit( (float)$v['allowance'], (float)$v['spend'], (float)$v['save'], (float)$v['give'], $cid );
				$this->childrenclass->updatePaydate( $cid, $date );
				$this->allowanceReminder( $cid, $pid, $date, $fre, $v );
			}

			// do achievement checking


			// check allocation achievements
			setAllocationAmountAchievement(4, $cid);
			setAllocationAmountAchievement(5, $cid);
			setAllocationAmountAchievement(6, $cid);
			setAllocationAmountAchievement(7, $cid);
			setAllocationAmountAchievement(8, $cid);
			setAllocationAmountAchievement(9, $cid);
			setAllocationAmountAchievement(10, $cid);

			// check wishlist achievement
			setWishlistAchievement($cid);
			
		}
	}

    function test(){
        $query = "
			SELECT id, user_id, DATEDIFF(NOW(), FROM_UNIXTIME(logged_in)) as days, logged_in, logged_out
			FROM user_tracking
			WHERE user_id = ?
			ORDER BY logged_in DESC
			LIMIT 1
		";

        $advisor_id = 2;
        $parentInactive = false;
        $childInactive = false;

        $childrenForEmail = array();
        $p = $this->parentsclass->getParentIdByUserId(745);
        $result = $this->db->query($query, array(745))->result();
//        var_dump($result[0]->days);
//        die;
        if ( count($result) > 0 && $result[0]->days == '45')
        {
            $parentInactive = true;
        }
        $children = $this->childrenclass->getChildInfoByParent(324);

        if (count($children))
        {
            echo 'have children: '.count($children).'<br>';
            foreach ($children as $c)
            {
                $childrenForEmail = $c;

                $result = $this->db->query($query, array($c['user_id']))->result();

                if (count($result) > 0 && $result[0]->days == '45')
                {
                    $childInactive = true;
                    echo 'childInactive'.$childInactive.'<br>';
//                    sendNotification("Dragon Bank - Parent/Children Inactivity", advisorLogin($a), $a->user_email);
                }
            }
        }

        echo '$parentInactive:'.$parentInactive.'<br>';
        echo 'childInactive'.$childInactive.'<br>';
        if ($parentInactive || $childInactive)
        {

            sendNotification("Dragon Bank - Parent/Children Inactivity", parentChildrenLogin($p, $children), $p->user_email);
            echo '$parentInactive || $childInactive'.'<br>';

            if ($advisor_id != NULL)
            {
                $advisor = $this->advisorsclass->getAdvisorByID($advisor_id);
                echo '$advisor_id != NULL';
                sendNotification("Dragon Bank - Parent/Children Inactivity", advisorParentChildLogin($advisor, $p, $children), $advisor->user_email);
            }
        }
    }
}