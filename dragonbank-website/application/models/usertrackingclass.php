<?php

class Usertrackingclass extends _Mymodel{

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('user_tracking','id');
	}

	public function trackLoginTime($uid)
	{
		$time = time();
		$record = array("user_id" => $uid, "logged_in" => $time, "logged_out" => $time);
		return $this->add($record);
	}

	public function trackLogoutTime($id)
	{
		$record = array("id" => $id, "logged_out" => time());
		$this->update($record);
	}

	public function countLogins( $type )
	{
		return $this->getOneWhere("user_id >", 0,  "count($type)");
	}

	public function countUserLogins( $uid )
	{
		return $this->getOneWhere("user_id", (int)$uid,  "count(user_id)");
	}

	public function getLoginDurations()
	{
		return $this->getWhere_array("user_id >", 0,  "(logged_out - logged_in) as DURATION");
	}

	public function getLoginsByUserID($id)
	{
		$this->db->where('user_tracking.user_id', $id);
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}

	public function getLastLoginByUserID($id)
	{
		$this->db->select('user_id, MAX(logged_in) logged_in, logged_out');
		$this->db->where('user_tracking.user_id', $id);
		$this->db->group_by('id, user_id');
		$this->db->order_by('logged_in DESC');
		$this->db->limit(1);
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}
}