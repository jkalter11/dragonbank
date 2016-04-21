<?php

class Codesclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('codes','id');
	}
	
	/**
	 * Set to default table
	 */
	private function table(){
		$this->setTable('codes', 'id');
	}

	public function getCodesByCDA($cid, $rdid, $aid)
	{
		$this->db->select('codes.*');
		$this->db->where('company_id', $cid);
		if ($rdid != 0)
		{
			$this->db->where('regional_director_id', $rdid);
		}

		if ($aid != 0)
		{
			$this->db->where('advisor_id', $aid); 
		}

		$this->db->order_by('date ASC');

		$results = $this->db->get($this->_tableName);
		return $results->result();
	}
	
	/**
	 * Checks for unique codes
	 *
	 * @param (string) $code: Access code name.
	 */
	public function uniqueCode( $code ){
	
		// We want to retuen TRUE if the code is unique.
		$result = ( ! $this->exists( $code, 'codename' ) );
		
		return $result;
	}
	
	/**
	 * Get single code
	 */
	public function getCode($id){
		$code = $this->getWhere_array('id', (int)$id );
		
		if( ! $code )
			return false;
		return $code[0];
	}
	
	 /**
	 * Get codes by list
	 */
	public function getCodesByList($list_id){
		return $this->getWhere_array('code_list_id', (int)$list_id, "id, codename, date, export_date, exported" );
	}
	
	/**
	 * Get codes by list
	 */
	public function getCodeIdByListId($list_id){
		return $this->getOneWhere('code_list_id', (int)$list_id, 'id' );
	}
	/**
	 * Gets code id by name 
	 */
	public function getCodeIdByName( $codename )
	{
		return $this->getOneWhere('codename', $codename, 'id' );
	}
   
	/**
	 * Get code list
	 */
	public function getAllCodes(){

		return $this->getAll_array();
	}
	  
	/**
	 * Get code's status
	 */
	public function codeStatus( $id ){
		return $this->getOneWhere('id', (int)$id, 'status');
	}
	
	/**
	 * Get code's status
	 */
	public function codeStatusByName( $codename ){
		return $this->getOneWhere('codename', $codename, 'id, status, advisor_id');
	}
	
	public function getCodeData( $id ){
	
		return $this->getOneWhere('id', $id, 'codename, code_list_id');
	
	}
	
	public function searchByDate($start = 0, $end = 0, $list_id = 0, $limit = null, $lstart = null)
	{
		$where = array();

		if( $start !== 0 )
		{
			$where['date >='] = $start;
		}
		
		if( $end !== 0 )
		{
			$where['date <='] = $end;
		}
		
		if( $list_id > 0 )
		{
			$where['code_list_id'] = $list_id;
		}

		
		$this->db->select('codes.id, codes.codename, codes.date, codes.export_date, companies.name company, users.user_full_name advisor');
		$this->db->join('regional_directors', 'regional_directors.id = codes.regional_director_id');
		$this->db->join('companies', 'companies.id = codes.company_id', 'left');
		$this->db->join('advisors', 'advisors.id = codes.advisor_id', 'left');
		$this->db->join('users', 'users.user_id = advisors.user_id', 'left');
		
		if ($start !== 0)
		{
			$this->db->where('date >=', $start);
		}

		if ($end !== 0)
		{
			$this->db->where('date <=', $end);
		}

		if ($list_id > 0)
		{
			$this->db->where('code_list_id', $list_id);
		}

		$results = $this->db->get('codes');

		$sql = $results->result_array();

		$sql['pages'] = $results->num_rows();

		return $sql;

		/*
		$query = "
			SELECT codes.codename, codes.date, codes.export_date, companies.name companyname, users.user_full_name advisor
			FROM codes
			LEFT JOIN companies
			ON codes.company_id = companies.id
			LEFT JOIN advisors
			ON codes.advisor_id = advisors.id
			LEFT JOIN users
			ON advisors.user_id = users.user_id
		"
		*/
		//$sql = $this->getWhere_array( $where, NULL, "id, codename, date, export_date", null, $limit, $lstart);
		
		//$sql['pages'] = (int)$this->countWhich( $where, "id" ); 
		
		//return $sql;
	}
}