<?php

class Childrenachievementclass extends _Mymodel {

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('children_achievements');
	}
	
	/**
	 * Set to default table
	 */
	
	public function getStatusOnChallengeID($id, $child)
	{
		$this->db->select('children_achievements.status');
		$this->db->join('achievements', 'achievements.id = children_achievements.achievement_id');
		$this->db->where('challenge_id', $id);
		$this->db->where('children_id', $child);

		$results = $this->db->get($this->_tableName);
		if ($results->num_rows() == 0)
		{
			return -1; // achievement hasn't been unlocked
		}

		// 1 = unlocked, 0 = hasn't been approved by parent
		$r = $results->row();
		return $r->status;
	}

	public function setAchievementOnChallengeID($cid, $child)
	{
		$this->db->select('id');
		$this->db->where('challenge_id', $cid);
		$result = $this->db->get('achievements');
		$result = $result->row();
		$aid = $result->id;
		
		$data = array(
			'achievement_id' => $aid,
			'children_id' => $child,
			'date' => time(),
			'toast' => 1,
			'status' => 0
		);

		$this->db->insert($this->_tableName, $data);

	}

	public function setConfirmOnChallengeID($cid, $child)
	{
		$this->db->select('id');
		$this->db->where('challenge_id', $cid);
		$result = $this->db->get('achievements');
		$result = $result->row();
		$aid = $result->id;
		
		$data = array(
			'status' => 1
		);

		$this->db->where('achievement_id', $aid);
		$this->db->where('children_id', $child);

		$this->db->update($this->_tableName, $data);
	}

}