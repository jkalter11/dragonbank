<?php

	if (!defined('APPPATH'))
		exit('No direct script access allowed');


	function getTip()
	{
		$CI = &get_instance();

		$query = "
			SELECT * 
			FROM tips 
			WHERE status = 1
			ORDER BY RAND() 
			LIMIT 1
		";

		$result = $CI->db->query($query);
		$result = $result->row();

		$tip = array();
		$tip['text'] = $result->text;
		$tip['author'] = $result->author;

?>
		<p><strong>"<?= $tip['text']; ?>"</strong></p>
		<p class="text-right"><em>- <?= $tip['author']; ?></em></p>
<?php
	}
