<?php

class Advisorsclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('advisors');
	}

	public function getCount()
	{
		return $this->size();
	}

	public function getParents($aid)
	{
		$query = "SELECT * FROM parents WHERE company_id = ?";
		return $this->db->query($query, $cid);
	}

	private function setBaseQuery()
	{
		$this->db->select('ua.*');
		$this->db->select('advisors.id, advisors.position, advisors.address1, advisors.address2, advisors.city, advisors.province_id, provinces.code province_code, advisors.postalcode, advisors.cell, advisors.fax, advisors.website, advisors.photo, advisors.regional_director_id');
		$this->db->select('companies.name as company, companies.logo');
		$this->db->select('urd.user_full_name rdname');
		$this->db->select('COUNT(parents.parent_id) parentCount');
		$this->db->join('users ua', 'ua.user_id = advisors.user_id', 'left');
		$this->db->join('regional_directors', 'regional_directors.id = advisors.regional_director_id', 'left');
		$this->db->join('companies', 'companies.id = regional_directors.company_id', 'left');
		$this->db->join('parents', 'parents.advisor_id = advisors.id', 'left');
		$this->db->join('provinces', 'provinces.id = advisors.province_id', 'left');
		$this->db->join('users urd', 'urd.user_id = regional_directors.user_id', 'left');
		$this->db->group_by('advisors.id');
	}

	public function getAdvisors($page = 0, $count = 20)
	{
		$this->setBaseQuery();

		$this->db->order_by('ua.user_full_name ASC, company ASC');
		return $this->db->get($this->_tableName, $count, ($page - 1) * $count);
	}

	public function getAdvisorsByRD($rdid, $active = false)
	{
		$this->setBaseQuery();

		$this->db->where('advisors.regional_director_id', $rdid);
		if ($active)
		{
			$this->db->where('ua.status', 1);
		}
		$this->db->order_by('ua.user_full_name ASC, company ASC');
		return $this->db->get($this->_tableName);
	}

	public function getAdvisorsByCompany($cid)
	{
		$this->setBaseQuery();

		$this->db->where('companies.id', $cid);
		$this->db->order_by('ua.user_full_name ASC, company ASC');
		return $this->db->get($this->_tableName);
	}

	public function searchAdvisorsByName($name)
	{
		$this->setBaseQuery();

		$this->db->like('ua.user_full_name', $name);
		$this->db->order_by('ua.user_full_name ASC, company ASC');
		return $this->db->get($this->_tableName);
	}

	public function getAdvisorByUserID($id)
	{
		//$this->setBaseQuery();
		$this->db->select('advisors.*, provinces.code province_code');
		$this->db->join('provinces', 'provinces.id = advisors.province_id', 'left');
		$this->db->where('advisors.user_id', $id);
		$result = $this->db->get($this->_tableName);
		if ($result->num_rows() == 0)
		{
			return false;
		}
		return $result->row();
	}

	public function getAdvisorByID($id)
	{
		$this->setBaseQuery();
		$this->db->where('advisors.id', $id);
		$result = $this->db->get($this->_tableName);
		if ($result->num_rows() == 0)
		{
			return false;
		}
		return $result->row();
	}

	public function getAdvisorByParentID($pid)
	{
		$this->db->select('advisors.*, companies.name company, companies.logo, provinces.code province_code');
		$this->db->select('ua.*');
		$this->db->join('provinces', 'provinces.id = advisors.province_id', 'left');
		$this->db->join('users ua', 'ua.user_id = advisors.user_id');
		$this->db->join('parents', 'parents.advisor_id = advisors.id');
		$this->db->join('regional_directors', 'regional_directors.id = advisors.regional_director_id');
		$this->db->join('companies', 'companies.id = regional_directors.company_id');
		$this->db->where('parents.parent_id', $pid);
		$result = $this->db->get($this->_tableName);
		if ($result->num_rows() == 0)
		{
			return false;
		}
		return $result->row();
	}

	public function getActiveAdvisors()
	{
		$this->setBaseQuery();
		$this->db->where('ua.status', 1);
		$result = $this->db->get($this->_tableName);
		return $result->result();
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

}