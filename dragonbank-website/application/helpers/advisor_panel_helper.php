<?php

	if (!defined('APPPATH'))
		exit('No direct script access allowed');


	function load_advisor_panel($user_id = 0)
	{
		$CI = &get_instance();
		//$CI->load->model(array('usersclass', 'parentsclass', 'childrenclass', 'advisorsclass'));

		$fullname = $position = $address1 = $address2 = $city = $province = $postalcode = $phone = $cell = $fax = $email = $photo = '';
		$self = false;
		$dataready = false;

		// if no user id is submitted, use the session. This should be the case unless you really want to force the user id.
		if ($user_id == 0)
		{
			// get user id from session
			$user_id = $CI->session->userdata('user_id');
			$user_group = $CI->session->userdata('user_group');

			if ($user_id && $user_group)
			{
				// this is most likely the own user so his own session can be used.
				if ($user_group == 5)
				{
					$typeData = $CI->session->userdata('typeData');

					$fullname = $CI->session->userdata('user_name');
					$position = $typeData['position'];
					$address1 = $typeData['address1'];
					$address2 = $typeData['address2'];
					$city = $typeData['city'];
					$province = $typeData['province_code'];
					$postalcode = $typeData['postalcode'];
					$phone = $CI->session->userdata("phone");
					$cell = $typeData['cell'];
					$fax = $typeData['fax'];
					$email = $CI->session->userdata("name_email");
					$photo = $typeData['photo'];

					$self = true;

					$dataready = true;

				}
				// this is a parent
				else if ($user_group == 2 || $user_group == 3)
				{
					// IMPRESSION
					$CI->load->model(array('advisorsclass'));
					if ($user_group == 2)
					{
						$advisor = (array)$CI->advisorsclass->getAdvisorByParentID($CI->session->userdata('type_id'));
					}
					else
					{
						$query = "SELECT parent_id FROM children WHERE child_id = " . $CI->session->userdata('type_id');
						$result = $CI->db->query($query);
						$result = $result->row();
						$advisor = (array)$CI->advisorsclass->getAdvisorByParentID($result->parent_id);
					}

					if (isset($advisor['user_full_name']))
					{
						$company = $advisor['company'];
						$fullname = $advisor['user_full_name'];
						$position = $advisor['position'];
						$address1 = $advisor['address1'];
						$address2 = $advisor['address2'];
						$city = $advisor['city'];
						$province = $advisor['province_code'];
						$postalcode = $advisor['postalcode'];
						$phone = $advisor['user_phone'];
						$cell = $advisor['cell'];
						$fax = $advisor['fax'];
						$email = $advisor['user_email'];
						$photo = $advisor['photo'];
						$dataready = true;
						$self = false;

						$data = array(
							'advisor_id' => $advisor['id'],
							'user_id' => $CI->session->userdata('user_id'),
							'date' => time()
						);

						$CI->db->insert('impressions', $data);
					}
				}

			}
		}

		if ($dataready)
		{
			$address = (!empty($address2) ? $address2 . ', ' : '') . $address1;

			if ($user_group == 2 || $user_group == 3)
			{
?>
<div class="col-sm-4">
<?php
			}
?>
					<div id="advisor-panel" class="row">
						<div class="col-sm-4 no-padding">
							<img src="<?= ADV_PROFILE_PATH . $photo; ?>" alt="" title="">
							
						</div>
						<div class="col-sm-8 profile-details">
<?php
			// show the company if not self
			if (!$self && isset($company) && !empty($company))
			{
?>
							<strong><u><?= $company; ?></u></strong><br>
<?php
			}
?>
							<strong><?= $fullname; ?></strong><br>
<?php 
			if (!empty($position))
			{
				echo "\t\t\t\t\t\t\t" . $position . "<br>\n";
			}
?>
							<?= $address . "<br>\n"; ?>
							<?= $city . ', ' . $province . ', ' . $postalcode ."<br>\n"; ?>
<?php 
			if (!empty($phone)) 
			{
				echo "\t\t\t\t\t\t\to: " .  $phone . "<br>\n";
			}

			if (!empty($cell))
			{
				echo "\t\t\t\t\t\t\tc: " . $cell . "<br>\n";
			}

			if (!empty($fax))
			{
				echo "\t\t\t\t\t\t\tf: " . $fax . "<br>\n";
			}
?>
							<?= '<a href="mailto:' . $email . '">' . $email . "</a><br>\n"; ?>
<?php
			// only show the edit link if its self
			if ($self)
			{
?>
							<a href="/advisors/settings/profile" class="btn btn-info btn-xs btn-block">EDIT</a>
<?php
			}
?>
						</div>
					</div>
<?php
			if ($user_group == 2 || $user_group == 3)
			{
?>
</div>
<?php
			}
			return true;
		}
		else
		{
			return false;
		}
	}