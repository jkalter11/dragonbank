<?php

	if (!defined('APPPATH'))
		exit('No direct script access allowed');


	function load_advisor_stats()
	{
		$CI = &get_instance();
		$codesused = $dbunused = $totalimpressions = $videounused = 0;

		$typeData = $CI->session->userdata('typeData');

		// get codes used
		$query = "SELECT COUNT(id) codesused FROM codes WHERE advisor_id = ? AND status = 0";
		$result = $CI->db->query($query, array($typeData['id']));
		$result = $result->row();

		$codesused =  $result->codesused;


		// get db codes unused
		$query = "SELECT COUNT(id) dbunused FROM codes WHERE advisor_id = ? AND status = 1";
		$result = $CI->db->query($query, array($typeData['id']));
		$result = $result->row();

		$dbunused = $result->dbunused;


		// get impressions
		$query = "SELECT COUNT(id) impressions FROM impressions WHERE advisor_id = ?";
		$result = $CI->db->query($query, array($typeData['id']));
		$result = $result->row();

		$totalimpressions = $result->impressions;


?>
<div id="client-stats">
	<div class="row">
		<div class="col-sm-3">
			<strong>Families<br>Engaged</strong>
			<div><?= $codesused; ?></div>
		</div>
		<div class="col-sm-3">
			<strong>Dragon Banks<br>Remaining</strong>
			<div><?= $dbunused; ?></div>
		</div>
		<div class="col-sm-3">
			<strong>Total<br>Impressions</strong>
			<div><?= $totalimpressions; ?></div>
		</div>
		<div class="col-sm-3">
			<strong>Video Codes<br>Remaining</strong>
			<div><?= $videounused; ?></div>
		</div>
	</div>
</div>
<?php
	}