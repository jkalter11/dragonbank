<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ajax_timezone.php Controller Class.
 */
class Ajax_timezone extends Application 
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		$this->session->set_userdata("timezone", $_GET['time']);

		echo json_encode("true");
	}
}