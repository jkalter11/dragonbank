<?php

	if (!defined('APPPATH'))
		exit('No direct script access allowed');


	function set_message($text, $class, $list = null)
	{
		$CI = &get_instance();

		$message = array();
		$message['text'] = $text;
		$message['class'] = $class;
		$message['list'] = $list;

		$CI->session->set_userdata('message', $message);
	}

	function display_message($width = 100)
	{
		$CI = &get_instance();

		$message = $CI->session->userdata('message');

		if ($message)
		{
?>
<div class="alert top-margin <?= $message['class']; ?> alert-dismissible" role="alert" style="width: <?= $width; ?>%">
	<button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
	<?= $message['text'] . "\n" ?>
<?php
	if ($message['list'] != null)
	{
		echo "\t<ul>\n";

		foreach ($message['list'] as $m)
		{
			echo "\t\t<li>" . $m . "</li>\n";
		}

		echo "\t</ul>\n";
	}
?>
</div>
<?php
			$CI->session->unset_userdata('message');
		}
	}