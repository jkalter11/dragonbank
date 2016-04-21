<?php

class Challengestepsclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('challenge_steps');
	}

	public function getCount()
	{
		return $this->size();
	}

	public function getStepsList()
	{
		$this->db->where('status', 1);
		$results = $this->db->get($this->_tableName);
		if ($results->num_rows() == 0)
		{
			return false;
		}

		return $results->result();

	}

	public function getStepsByChallengeID($id)
	{
		$this->db->where('challenge_id', $id);
		$this->db->where('status', 1);
		$results = $this->db->get($this->_tableName);
		if ($results->num_rows() == 0)
		{
			return false;
		}
		
		return $results->result();
	}

}