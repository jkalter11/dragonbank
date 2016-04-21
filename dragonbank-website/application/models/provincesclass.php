<?php

class Provincesclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('provinces');
	}

	public function getCount()
	{
		return $this->size();
	}

	public function getProvinces()
	{
		//$this->db->select('*');
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}
	
	/**
	 * Get code list name by id
	 */
	public function getProvinceByCode($id)
	{
		//return $this->getOneWhere('id', (int)$id , 'name');
	}
	
	/**
	 * Gets list id by name 
	 */
	public function getProvinceByID( $name )
	{
		//return $this->getOneWhere('name', htmlspecialchars( $name ), 'id' );
	}

	/**
	 * Get active code list
	public function getActiveCodeList(){
		return $this->getWhere_array('active', 1);
	}
	*/
}