<?php

class Cron extends Application {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->library("crontab");
	}
	
	function index()
	{
		// Uncomment cron->add_job to set another cron job.
		$this->crontab->add_job("0 0 * * *", "allowance_cron");
        return;
	}

}