<?php

class Email_template extends Application
{
	function __construct()
	{
		parent::__construct();
	}
	
	function index()
	{
		
        $this->load->view("email_template", $this->data);
	}
}