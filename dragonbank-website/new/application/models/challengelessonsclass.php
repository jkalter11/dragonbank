<?php

class Challengelessonsclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('challenge_lessons');
	}

	public function getCount()
	{
		return $this->size();
	}

	public function getLessonsList()
	{
		$this->db->where('status', 1);
		$results = $this->db->get($this->_tableName);
		if ($results->num_rows() == 0)
		{
			return false;
		}

		return $results->result();

	}

	public function getLessonsByChallengeID($id)
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