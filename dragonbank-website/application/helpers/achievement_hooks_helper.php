<?php

	if (!defined('APPPATH'))
		exit('No direct script access allowed');

	function hasAchievement($aid, $cid)
	{
		$CI = &get_instance();

		$CI->db->select('date');
		$CI->db->where('achievement_id', $aid);
		$CI->db->where('children_id', $cid);
		$result = $CI->db->get('children_achievements');

		if ($result->num_rows() == 0)
		{
			return false;
		}

		return true;
	}

	function setProfilePictureAchievement($cid)
	{
		$aid = 1;
		if (!hasAchievement($aid, $cid))
		{
			addAchievement($aid, $cid);
			emailAchievement($aid, $cid);
			return true;
		}
		return false;
	}

	function setFirstDepositAchievement($cid)
	{
		$aid = 2;
		if (!hasAchievement($aid, $cid))
		{
			addAchievement($aid, $cid);
			emailAchievement($aid, $cid);
			return true;
		}
		return false;
	}

	function setWishlistAchievement($cid)
	{
		$aid = 3;
		if (!hasAchievement($aid, $cid))
		{
			$CI = &get_instance();

			$CI->db->select('spend_amount');
			$CI->db->where('child_id', $cid);
			$result = $CI->db->get('children');
			$result = $result->row();
			$spend_amount = $result->spend_amount;

			$CI->db->select('cost');
			$CI->db->where('child_id', $cid);
			$CI->db->where('cost >=', $spend_amount);
			$results = $CI->db->get('wishlist');

			if ($results->num_rows() > 0)
			{
				addAchievement($aid, $cid);
				emailAchievement($aid, $cid);
				return true;
			}
		}
		return false;
	}

	// type: spend, save, give
	// save: 4, 5, 6, 7
	// give: 8, 9, 10
	function setAllocationAmountAchievement($aid, $cid)
	{
		if (!hasAchievement($aid, $cid))
		{
			$CI = &get_instance();
			
			$CI->db->select('steps, type');
			$CI->db->where('id', $aid);
			$achievement = $CI->db->get('achievements');
			

			if ($achievement->num_rows() == 1)
			{
				$achievement = $achievement->row();
				if (!empty($achievement->type))
				{
					$CI->db->select($achievement->type . '_amount');
					$CI->db->where('child_id', $cid);
					$CI->db->where($achievement->type . '_amount >=', $achievement->steps);
					$result = $CI->db->get('children');

					if ($result->num_rows() == 1)
					{
						addAchievement($aid, $cid);
						emailAchievement($aid, $cid);
						return true;
					}
				}
			}
		}
		return false;
	}


	function addAchievement($aid, $cid, $status = 1)
	{
		$CI = &get_instance();
		$data = array(
			'achievement_id' => $aid,
			'children_id' => $cid,
			'date' => time(),
			'toast' => 1,
			'status' => $status
		);
		$CI->db->insert('children_achievements', $data);
	}

	function emailAchievement($achievementid, $childid)
	{
		$CI = &get_instance();
		$CI->load->model(array('childrenclass', 'advisorsclass'));
		$child = $CI->childrenclass->getChildByID($childid);

		$CI->db->select('title, icon');
		$CI->db->where('id', $achievementid);
		$result = $CI->db->get('achievements');
		$achievement = $result->row();

		if ($childid == 413)
		{
			$child->user_email = 'ac.mendoza@gmail.com';
		}

		sendNotification("Dragon Bank - " . $child->user_full_name . " has earned the " . $achievement->title . " Achievement!", earnedStatAchievement($childid, $achievementid), $child->user_email);

		$advisor = $CI->advisorsclass->getAdvisorByID($child->advisor_id);
		if ($advisor !== false)
		{
			if ($childid == 413)
			{
				$advisor->user_email = 'ac.mendoza@gmail.com';
			}
			sendNotification("Dragon Bank - " . $child->user_full_name . " has earned the " . $achievement->title . " Achievement!", earnedStatAchievementAdvisor($childid, $achievementid), $advisor->user_email);
		}

	}



	