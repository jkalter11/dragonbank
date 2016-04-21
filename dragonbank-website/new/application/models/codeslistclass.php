<?php

class Codeslistclass extends _Mymodel {

    /**
     * Constructor to create instance of DB object
     */
    public function __construct(){
        parent::__construct();
        $this->setTable('codes_list','id');
    }
    
    /**
     * Get code list name by id
     */
    public function getCodeListName( $id ){
    	return $this->getOneWhere('id', (int)$id , 'codelistname');
    }
	
	/**
	 * Gets list id by name 
	 */
	public function getIdByName( $name )
	{
		return $this->getOneWhere('codelistname', htmlspecialchars( $name ), 'id' );
	}

    /**
     * Get code list
     */
    public function getAllLists(){

      	return $this->getAll_array();
    }

    /**
     * Get active code list
     */
    public function getActiveCodeList(){
    	return $this->getWhere_array('active', 1);
    }
}