<?php

	if (!defined('APPPATH'))
		exit('No direct script access allowed');


	function getAchievements($cid)
	{
		$CI = &get_instance();

		$query = "
			SELECT *
			FROM achievements
			WHERE status = 1
		";

		$achievements = $CI->db->query($query);
		$achievements = $achievements->result();
?>
									<div class="row">
										<div class="col-content">
<?php
		$i = 0;
		foreach ($achievements as $a)
		{

			$query = "
				SELECT *
				FROM children_achievements
				WHERE achievement_id = " . $a->id . "
				AND children_id = " . $cid ."
				AND status = 1";

			$results = $CI->db->query($query);

			$class = 'grayed';
			$title = 'Locked: ' . $a->title;
			if ($results->num_rows())
			{
				$class = '';
				$title = 'UNLOCKED: ' . $a->title;
			}

?>
											<div class="col-sm-4 short-padding">
												<img src="<?= ACH_IMG_PATH . $a->icon; ?>" title="<?= $title; ?>" alt="<?= $title; ?>" class="<?= $class; ?>">
											</div>
<?php
		}
?>
										</div>
									</div>
<?php
	}

	