<?php

class Challengesclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('activities_challenges');
	}

	public function getCount()
	{
		return $this->size();
	}

	public function getChallengesList($all = true)
	{
		$this->db->select('id, title, description, content1');
		$this->db->where('type', 2);
		if (!$all)
		{
			$this->db->where('status', 1);
		}
		$this->db->order_by('order ASC');
		$results = $this->db->get($this->_tableName);
		if ($results->num_rows() == 0)
		{
			return false;
		}

		return $results->result();

	}

	public function getChallenges($all = true)
	{
		$this->db->where('type', 2);
		if (!$all)
		{
			$this->db->where('status', 1);
		}
		$results = $this->db->get($this->_tableName);
		if ($results->num_rows() == 0)
		{
			return false;
		}
		
		return $results->result();
	}

	public function getChallenge($id)
	{
		$this->db->select('activities_challenges.id, activities_challenges.title, activities_challenges.description, activities_challenges.content1, activities_challenges.file, achievements.icon, achievements.title achievement_title');
		$this->db->join('achievements', 'achievements.challenge_id = activities_challenges.id');
		$this->db->where('activities_challenges.id', $id);
		$results = $this->db->get($this->_tableName);
		if ($results->num_rows() == 0)
		{
			return false;
		}
		
		return $results->row();

	}

}