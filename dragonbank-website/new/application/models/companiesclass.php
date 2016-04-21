<?php

class Companiesclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('companies');
	}

	public function getCount()
	{
		return $this->size();
	}

	public function getRegionalDirectors($cid)
	{
		$query = "SELECT * FROM regional_directors WHERE company_id = ?";
		return $this->db->query($query, $cid);
	}

	public function getCompanyByAdvisorID($aid)
	{
		$this->db->select('companies.*');
		$this->db->join('regional_directors', 'regional_directors.company_id = companies.id', 'left');
		$this->db->join('advisors', 'advisors.regional_director_id = regional_directors.id', 'left');
		$this->db->where('advisors.id', $aid);
		$result = $this->db->get($this->_tableName);
		return $result->row();
	}
	
	/**
	 * Get code list name by id
	 */
	public function getName($id)
	{
		return $this->getOneWhere('id', (int)$id , 'name');
	}
	
	/**
	 * Gets list id by name 
	 */
	public function getIdByName( $name )
	{
		return $this->getOneWhere('name', htmlspecialchars( $name ), 'id' );
	}

	/**
	 * Get code list
	 */
	public function getAllLists(){

		return $this->getAll_array();
	}

	public function getActiveCompanies()
	{
		$this->db->select('companies.*');
		$this->db->where('status', 1);
		$this->db->order_by('name ASC');
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}
}