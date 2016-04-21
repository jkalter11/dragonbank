<?php

	if (!defined('APPPATH'))
		exit('No direct script access allowed');


	function showToast()
	{
		$CI = &get_instance();

		$user_group = $CI->session->userdata('user_group');

		if ($user_group != 3)
		{
			return false;
		}

		$CI->db->select('achievements.id, achievements.title, achievements.icon');
		$CI->db->join('achievements', 'achievements.id = children_achievements.achievement_id');
		$CI->db->where('toast', 1);
		$CI->db->where('children_achievements.status', 1);
		$CI->db->where('children_id', $CI->session->userdata('type_id'));

		$results = $CI->db->get('children_achievements');

		if ($results->num_rows())
		{
?>
	<div id="toast">
		<div id="toast-container">
			<h2>Congratulations!</h2>
			<ul id="toast-data">
<?php
		 	foreach ($results->result() as $r)
			{
				$data = array('toast' => 0);
				$CI->db->where('achievement_id', $r->id);
				$CI->db->where('children_id', $CI->session->userdata('type_id'));
				$CI->db->update('children_achievements', $data);


?>
				<li>
					<img src="<?= ACH_IMG_PATH . $r->icon; ?>" alt="<?= $r->title; ?>" title="<?= $r->title; ?>">
					<h3>You have successfully earned the</h3>
					<h2><?= $r->title; ?> Achievement!</h2>
				</li>
<?php
			}
?>
			</ul>

			<h4>Keep up the GREAT work!</h4>
			<a href="#" id="toast-close" class="btn btn-primary btn-lg">Close</a>
		</div>
	</div>
<?php
		}
	}

	