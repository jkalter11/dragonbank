<?php

class Settingsclass extends _Mymodel {

    /**
     * Constructor to create instance of DB object
     */
    public function __construct(){
        parent::__construct();
        $this->setTable('settings','settings_id');
    }
    
    /**
     * Set to default table
     */
    private function table(){
    	$this->setTable('settings', 'settings_id');
    }
	
	public function getSettings()
	{
		return $this->getAll_array();
	}
	
	public function getStatus()
	{
		return $this->getOneWhere("settings_id", 1, "site_status");
	}
	
	public function getDevEmail()
	{
		return $this->getOneWhere("settings_id", 1, "dev_email");
	}
	
	public function getProEmail()
	{
		return $this->getOneWhere("settings_id", 1, "pro_email");
	}
}