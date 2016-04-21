<?php

class Regionaldirectorsclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('regional_directors','id');
	}

	public function getCount()
	{
		return $this->size();
	}

	public function getAdvisors($rid)
	{
		$query = "SELECT * FROM advisors WHERE regional_director_id = ?";
		return $this->db->query($query, $rid);
	}

	private function setBaseQuery()
	{
		$this->db->select('regional_directors.*, companies.name as company, count(advisors.id) advisorCount');
		$this->db->select('users.*');
		$this->db->join('users', 'users.user_id = regional_directors.user_id', 'left');
		$this->db->join('companies', 'companies.id = regional_directors.company_id', 'left');
		$this->db->join('advisors', 'advisors.regional_director_id = regional_directors.id', 'left');
		$this->db->group_by('regional_directors.id');
	}

	public function getAvailableDirectors()
	{
		$this->setBaseQuery();
		$this->db->where('users.status', 1);
		$this->db->where('regional_directors.status', 1);
		$this->db->order_by('users.user_full_name ASC, company ASC');
		return $this->db->get($this->_tableName);
	}

	public function getDirectors($page = 0, $count = 20)
	{
		$this->setBaseQuery();

		$this->db->order_by('users.user_full_name ASC, company ASC');
		return $this->db->get($this->_tableName, $count, ($page - 1) * $count);
	}

	public function getDirectorsByCompany($cid, $active = false)
	{
		$this->setBaseQuery();
		
		$this->db->where('company_id', $cid);
		if ($active)
		{
			$this->db->where('regional_directors.status', 1);
		}

		$this->db->order_by('users.user_full_name ASC, company ASC');
		return $this->db->get($this->_tableName);
	}

	public function searchDirectorsByName($name)
	{
		$this->setBaseQuery();

		$this->db->like('users.user_full_name', $name);
		$this->db->order_by('users.user_full_name ASC, company ASC');
		return $this->db->get($this->_tableName);
	}
	
	/**
	 * Get code list name by id
	 */
	public function getName($id){
		return $this->getOneWhere('id', (int)$id , array('firstname', 'lastname'));
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

	/**
	 * Get active code list
	public function getActiveCodeList(){
		return $this->getWhere_array('active', 1);
	}
	*/
}