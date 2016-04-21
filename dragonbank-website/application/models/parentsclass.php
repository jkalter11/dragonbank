<?php
class Parentsclass extends _Mymodel {

    /**
     * Constructor to create instance of DB object
     */
    public function __construct(){
        parent::__construct();
        $this->setTable('parents','parent_id');
    }
	
	public function getParentIdByUserId( $uid )
	{
		return $this->getOneWhere('parent_user_id', (int)$uid, 'parent_id');
	}
	
	public function getStatus( $pid )
	{
		return $this->getOneWhere("parent_id", (int)$pid, "status");
	}

	public function getParentByUserId($id)
	{
		$this->db->select('parents.*');
	}

	public function getActiveParents()
	{
		$this->db->select('ua.*');
		$this->db->select('parents.*');
		$this->db->join('users ua', 'ua.user_id = parents.parent_user_id');
		$this->db->where('ua.status', 1);
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}


	public function getParentsByAdvisorID($aid)
	{
		$this->db->select('ua.*');
		$this->db->select('parents.*');
		$this->db->join('users ua', 'ua.user_id = parents.parent_user_id');
		$this->db->where('parents.advisor_id', $aid);
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}

	function getParentsCount( $s = "" )
	{
		if( strlen($s) > 0 )
		{
			$s = "AND ( users.user_email LIKE '%$s%' OR users.user_full_name LIKE '%$s%' ) ";
		}

		return count($this->getJoin_array(array("users"), array("parent_user_id = users.user_id"), "*", null, array("LEFT OUTER", "LEFT OUTER"), "users.status > 0 $s"));
	}
	
	public function getAllParents( $p = 0, $l = 0, $s = "" )
	{
		$limit = array();

		if( $l > 0 && $p > 0 ) {
			$limit['amount'] = $l;
			$limit['offset'] = ($p * $l) - $l;
		}

		if( strlen($s) > 0 )
		{
			$s = "AND ( users.user_email LIKE '%$s%' OR users.user_full_name LIKE '%$s%' ) ";
		}

		return $this->getJoin_array(array("users"), array("parent_user_id = users.user_id"), "*", null, array("LEFT OUTER", "LEFT OUTER"), "users.status > 0 $s" , $limit);
	}

    public function getParentsReminder()
    {
		$join = array( "users" => "parent_user_id = user_id AND users.status = 1" );

        return $this->getMultiJoin_array($join, "quarterly_reminder = 1", "parent_id, user_email, user_full_name");
    }
	
	public function getEmailName( $pid )
	{
		$join = array( "users" => "parent_user_id = user_id" );
		
		$result = $this->getMultiJoin_array( $join, "parent_id = $pid", "user_email, user_full_name, allowance_reminder");
		
		return $result[0];
	}
	
	public function getKids( $pid )
	{
		return $this->getOneWhere('parent_id', (int)$pid, "kids");
	}
	
	public function getNewsletters( $pid )
	{
		return $this->getOneWhere('parent_id', (int)$pid, "dragon_newsletter, quarterly_reminder, allowance_reminder");
	}

	public function getAllowanceStatus( $pid )
	{
		return $this->getOneWhere('parent_id', (int)$pid, "allowance_status");
	}
}