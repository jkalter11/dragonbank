<?php

class Allocationclass extends _Mymodel {

    /**
     * Constructor to create instance of DB object
     */
    public function __construct(){
        parent::__construct();
        $this->setTable('allocation','allocation_id');
    }
    
    /**
     * Set to default table
     */
    private function table(){
    	$this->setTable('allocation','allocation_id');
    }
    
	public function getAllocation( $id )
	{
		return $this->getOneWhere("allocation_id", (int)$id, 'allocation_name');
	}

}