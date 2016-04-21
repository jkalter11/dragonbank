<?php
/**
 * settings.php Controller Class.
 */
class Settings extends Application {

	function __construct(){
		parent::__construct();

		$this->load->model( array("usersclass", "settingsclass") );
	}

	function saveAdmin()
	{
		$rec = $_POST['user_info'];

		if( (int)$this->sud->user_group == 1  && isset( $rec['password'] ) && $rec['password'] != '' )
		{
			$rec['user_password'] = md5( $rec['password'] );

			unset( $rec['password'] );

			$rec['user_id'] = (int)$this->sud->user_id;

			if( save_or_update("usersclass", "user_id", "Admin Password", set_record('user', $rec) ) )
			{
				flash_redirect("admin/settings", status('', "Password Updated Successfully.", "green"), 'flash');
			}
			else
			{
				flash_redirect("admin/settings", status('', "Could not save password", "red"), 'flash');
			}
		}
	}

	function saveSettings()
	{
		$rec = $_POST['set_info'];

		if(save_or_update("settingsclass", "settings_id", "Settings", set_record('settings', $rec) ) )
		{
			flash_redirect("admin/settings", status('', "Settings Updated Successfully.", "green"), 'flash');
		}
		else
		{
			flash_redirect("admin/settings", status('', "Could not save settings", "red"), 'flash');
		}
	}

	function index(){

		if( isset( $_POST['set_info'] ) )
		{
			$this->saveSettings();
		}
		else if( isset( $_POST['user_info'] ) )
		{
			if( ! isset( $this->sud->user_id ) || ! isset( $this->sud->user_group ) )
			{
				flash_redirect("admin/settings", status('', "Could not save password", "red"), 'flash');
			}
			$this->saveAdmin();
		}

		$this->data['pagebody']  = 'settings';
		$this->data['pagetitle'] = 'Dragon Bank | Settings ';
		$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$data['dev'] = $this->settingsclass->getDevEmail();
		$data['pro'] = $this->settingsclass->getProEmail();
		$data['sta'] = (int)$this->settingsclass->getStatus();

		$this->load->vars($data);

		$this->render("_template_admin");
	}
}

/* End of file settings.php */
/* Location: ./application/controllers/settings.php */