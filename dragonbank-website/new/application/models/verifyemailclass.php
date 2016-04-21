<?php

class Verifyemailclass extends _Mymodel {

    /**
     * Constructor to create instance of DB object
     */
    public function __construct(){
        parent::__construct();
        $this->setTable('verifyemail','id');
    }
    
    /**
     * Set to default table
     */
    private function table(){
    	$this->setTable('verifyemail', 'id');
    }
	
	public function getVerifyemailclass()
	{
		return $this->getAll_array();
	}
	
	public function getEmail( $key )
	{
		return $this->getOneWhere("email_verification_key", md5( urldecode( $key ) ),  "email");
	}
	
	public function getId( $pid )
	{
		return $this->getOneWhere("email_parent_id", (int)$pid, "email_parent_id");
	}
}