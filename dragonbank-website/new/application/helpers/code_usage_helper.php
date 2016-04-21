<?php

	if (!defined('APPPATH'))
		exit('No direct script access allowed');


	function load_code_usage()
	{
		$CI = &get_instance();

		$typeData = $CI->session->userdata('typeData');

		// get dragon bank used
		$query = "SELECT COUNT(id) codesused FROM codes WHERE advisor_id = ? AND status = 0 AND code_list_id = 1";
		$result = $CI->db->query($query, array($typeData['id']));
		$result = $result->row();

		$dbused =  $result->codesused;


		// get total dragonbanks
		$query = "SELECT COUNT(id) dbtotal FROM codes WHERE advisor_id = ? AND code_list_id = 1";
		$result = $CI->db->query($query, array($typeData['id']));
		$result = $result->row();

		$dbtotal = $result->dbtotal;


		// get dragon bank used
		$query = "SELECT COUNT(id) codesused FROM codes WHERE advisor_id = ? AND status = 0 AND code_list_id = 3";
		$result = $CI->db->query($query, array($typeData['id']));
		$result = $result->row();

		$videosused =  $result->codesused;


		// get total dragonbanks
		$query = "SELECT COUNT(id) videostotal FROM codes WHERE advisor_id = ? AND code_list_id = 3";
		$result = $CI->db->query($query, array($typeData['id']));
		$result = $result->row();

		$videostotal = $result->videostotal;

		$start = 51; // the height of the bar when it's starting;
		$end = 248;
		$barTotal = $end - $start;

		$DBbarCurrent = 0;
		if ($dbtotal > 0)
		{
			$DBbarCurrent = floor(($dbused / $dbtotal) * $barTotal);
		}

		$VbarCurrent = 0;
		if ($videostotal > 0)
		{
			$VbarCurrent = floor(($videosused / $videostotal) * $barTotal);
		}
?>
					<div id="code-usage" class="row">
						<div class="col-sm-6">
							<div class="thermometer-base">
								<div class="thermometer-fill" style="height: <?php echo (int)($start + $DBbarCurrent); ?>px;">
<?php
		if ($dbused < $dbtotal || $dbused == 0)
		{
?>
									<div class="indicator"><span><?php echo $dbused; ?></span></div>
<?php
		}
?>
								</div>
								<div class="code-max"><?php echo $dbtotal; ?></div>
							</div>
							<h5>Dragon Banks</h5>
						</div>
						<div class="col-sm-6">
							<div class="thermometer-base">
								<div class="thermometer-fill" style="height: <?php echo (int)($start + $VbarCurrent); ?>px;">
<?php
		if ($videosused < $videostotal || $videosused == 0)
		{
?>
									<div class="indicator"><span><?php echo $videosused; ?></span></div>
<?php
		}
?>
								</div>
								<div class="code-max"><?php echo $videostotal; ?></div>
							</div>
							<h5>Video Codes</h5>
						</div>
					</div>
<?php
	}