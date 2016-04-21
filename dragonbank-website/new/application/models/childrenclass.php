<?php

class Childrenclass extends _Mymodel {

    /**
     * Constructor to create instance of DB object
     */
    public function __construct(){
        parent::__construct();
        $this->setTable('children','child_id');
    }
	
	public function getChildInfoByParent( $pid )
	{
		$pid = (int)$pid;

		$join = array(
			"parents" 	=> "children.parent_id = parents.parent_id",
			"users as uc" 	=> "children.child_user_id = uc.user_id AND uc.status > 0",
		);

		$dupTables = array(
			"users as up" 	=> "parents.parent_user_id = up.user_id  AND up.status > 0",
		);

		$select = "
		children.child_id,
		children.profile_image,
		child_user_id,
		uc.user_id,
		children.parent_id,
		gender,
		birthday,
		allowance,
		balance,
		spend,
		spend_amount,
		save,
		save_amount,
		give,
		give_amount,
		children.status,
		parents.status as parent_status,
		allowance_frequency,
		allowance_payday,
		allocation_type,
		allowance_paydate,
		parent_user_id,
		uc.user_full_name,
		uc.user_name,
		up.user_full_name as  parent_name,
		uc.user_email,
		up.user_email as parent_email,
		parents.advisor_id,
		uc.registration_date,
		supports
		";


		return $this->getMultiJoin_array( $join, "children.parent_id = $pid", $select, NULL, $dupTables);
	}
	
	public function getParentId( $cid )
	{
		return $this->getOneWhere("child_id", (int)$cid, "parent_id");
	}
	
	public function getUserIdByParentId( $pid )
	{
		return $this->getWhere_array( "parent_id", (int)$pid, "child_user_id" );
	}
	
	public function getChildIdByUserId( $uid )
	{
		return $this->getOneWhere('child_user_id', (int)$uid, 'child_id');
	}
	
	public function getParentIdByUserId( $uid )
	{
		return $this->getOneWhere('child_user_id', (int)$uid, 'parent_id');
	}

	function getChildrenCount( $s = "" )
	{
		$where = NULL;
		if( strlen($s) > 0 )
		{
			$where = "( uc.user_email LIKE '%$s%' OR uc.user_full_name LIKE '%$s%' ) OR (  up.user_email LIKE '%$s%' OR up.user_full_name LIKE '%$s%'  )";
		}

		$join = array(
			"parents" 	=> "children.parent_id = parents.parent_id",
			"users as uc" 	=> "children.child_user_id = uc.user_id  AND uc.status > 0",
		);

		$dupTables = array(
			"users as up" 	=> "parents.parent_user_id = up.user_id  AND up.status > 0",
		);

		$select = "
		children.child_id,
		children.profile_image,
		child_user_id,
		uc.user_id,
		children.parent_id,
		gender,
		birthday,
		allowance,
		balance,
		spend,
		spend_amount,
		save,
		save_amount,
		give,
		give_amount,
		children.status,
		parents.status as parent_status,
		allowance_frequency,
		allowance_payday,
		allocation_type,
		allowance_paydate,
		parent_user_id,
		uc.user_full_name,
		up.user_full_name as  parent_name,
		uc.user_email,
		up.user_email as parent_email,
		parents.advisor_id,
		uc.registration_date
		";

		return $this->getMultiJoin_array( $join, $where, $select, NULL, $dupTables);
	}
	
	public function getAllChildren( $p = 0, $l = 0, $s = "" )
	{
		$where = NULL;
		$limit = array();

		if( $l > 0 && $p > 0 ) {
			$limit['amount'] = $l;
			$limit['offset'] = ($p * $l) - $l;
		}

		if( strlen($s) > 0 )
		{
			$where = "( uc.user_email LIKE '%$s%' OR uc.user_full_name LIKE '%$s%' ) OR (  up.user_email LIKE '%$s%' OR up.user_full_name LIKE '%$s%'  )";
		}

		$join = array(
			"parents" 	=> "children.parent_id = parents.parent_id",
			"users as uc" 	=> "children.child_user_id = uc.user_id  AND uc.status > 0",
		);

		$dupTables = array(
			"users as up" 	=> "parents.parent_user_id = up.user_id  AND up.status > 0",
		);

		$select = "
		children.child_id,
		children.profile_image,
		child_user_id,
		uc.user_id,
		children.parent_id,
		gender,
		birthday,
		allowance,
		balance,
		spend,
		spend_amount,
		save,
		save_amount,
		give,
		give_amount,
		children.status,
		parents.status as parent_status,
		allowance_frequency,
		allowance_payday,
		allocation_type,
		allowance_paydate,
		parent_user_id,
		uc.user_full_name,
		up.user_full_name as  parent_name,
		uc.user_email,
		up.user_email as parent_email,
		parents.advisor_id,
		uc.registration_date
		";

		return $this->getMultiJoin_array( $join, $where, $select, NULL, $dupTables, $limit);
	}
	
	public function getChild( $cid )
	{	
		$join = array( "users" => "child_user_id = user_id" );
		$where= array("child_id" => (int)$cid );
		
		return $this->getMultiJoin_array( $join, $where );
	}
	
	public function getTotalAmount()
	{
		$sum = array( "spend" => "spend_amount", "save" => "save_amount", "give" => "give_amount" );
		
		return $this->sumWhich( $sum, array( "status !=" => 0 ), TRUE );
	}

	public function getTotals( $type )
	{
		return $this->getOneWhere("status != 0 AND child_id > 0", NULL,  "sum($type)");
	}

	public function countAllowanceFreq( $type )
	{
		return $this->getOneWhere("allowance_frequency", $type,  "count(child_id)");
	}

	public function getAverage( $type )
	{
		return $this->getOneWhere("child_id >", 0,  "AVG($type)");
	}
	
	/**
	 * Gets child allocation
	 *
 	 * @param  $cid: The child's ID.
	 */
	public function getChildsAllocation( $cid )
	{
		return $this->getWhere_array("child_id", (int)$cid, "spend, save, give");
	}
	
	public function getAccounts( $cid )
	{
		return $this->getOneWhere("child_id", (int)$cid, "spend_amount, save_amount, give_amount");
	}
	
	/**
	 * Gets child's balance.
	 */ 
	public function getBalance( $cid )
	{
		return (float)$this->getOneWhere('child_id', (int)$cid, 'balance');
	}
	
	/**
	 * Gets all children with allowance greater than 0.00 
	 */
	public function getAllowances()
	{
		$join = array( "allocation" => "allocation_id = allocation_type",
					   "parents" => "children.parent_id = parents.parent_id",
		);

		$select = "
			parents.allowance_status,
			children.parent_id,
			child_id,
			allowance_paydate,
			allowance_frequency,
			allowance,
			spend,
			save,
			give,
			allocation_name,
			balance,
			spend_amount,
			give_amount,
			save_amount,
			gender,
			parents.advisor_id
		";

		$where = "allowance > 0.00 AND children.status = 1 AND allowance_status = 1";

		return $this->getMultiJoin_array($join, $where, $select);
	}

	public function getTotalGender( $gender = "Male" )
	{
		return $this->getOneWhere("gender = '$gender' AND status > 0", NULL, 'count(child_id)');
	}

	public function getAllAges()
	{
		return $this->getWhere_array("child_id >", 0, "birthday");
	}
	
	/**
	 * Gets all children with allowance greater than 0.00 
	 */
	public function getChildAllowance( $cid )
	{
		return $this->getOneWhere("child_id", (int)$cid, "child_id, allowance_frequency, allowance_payday, allowance_paydate");
	}
	
	public function updatePaydate( $cid, $date )
	{
		return $this->updateWhere(array("allowance_paydate" => $date), "child_id", (int)$cid );
	}

	public function getChildrenWithBirthdaysByAdvisorID($id)
	{
		$this->db->select('children.*');
		$this->db->select('uc.user_full_name');
		$this->db->select('up.user_full_name parentname, up.user_email, parents.advisor_id');
		$this->db->join('users uc', 'uc.user_id = children.child_user_id');
		$this->db->join('parents', 'parents.parent_id = children.parent_id');
		$this->db->join('users up', 'up.user_id = parents.parent_user_id');
		$this->db->where('MONTH(birthday) = MONTH(NOW())');
		$this->db->where('parents.advisor_id', $id);
		$this->db->where('children.status', 1);
		$this->db->order_by('DAY(birthday) ASC');
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}

	public function getChildrenByAdvisorID($id)
	{
		$this->db->select('children.*');
		$this->db->select('uc.user_full_name');
		$this->db->select('up.user_full_name parentname, up.user_email, parents.advisor_id');
		$this->db->join('users uc', 'uc.user_id = children.child_user_id');
		$this->db->join('parents', 'parents.parent_id = children.parent_id');
		$this->db->join('users up', 'up.user_id = parents.parent_user_id');
		$this->db->where('parents.advisor_id', $id);
		$this->db->where('children.status', 1);
		$this->db->order_by('up.user_full_name ASC, uc.user_full_name ASC');
		$results = $this->db->get($this->_tableName);
		return $results->result();
	}

	public function getChildByUserID($id)
	{
		$this->db->select('children.*');
		$this->db->select('uc.user_full_name');
		$this->db->select('up.user_full_name parentname, up.user_email, parents.advisor_id');
		$this->db->join('users uc', 'uc.user_id = children.child_user_id');
		$this->db->join('parents', 'parents.parent_id = children.parent_id');
		$this->db->join('users up', 'up.user_id = parents.parent_user_id');
		$this->db->where('uc.user_id', $id);
		$this->db->where('children.status', 1);
		$this->db->order_by('up.user_full_name ASC, uc.user_full_name ASC');
		$results = $this->db->get($this->_tableName);
		return $results->row();
	}

	public function getChildByID($id)
	{
		$this->db->select('children.*');
		$this->db->select('uc.user_full_name');
		$this->db->select('up.user_full_name parentname, up.user_email, parents.advisor_id');
		$this->db->join('users uc', 'uc.user_id = children.child_user_id');
		$this->db->join('parents', 'parents.parent_id = children.parent_id');
		$this->db->join('users up', 'up.user_id = parents.parent_user_id');
		$this->db->where('children.child_id', $id);
		$this->db->where('children.status', 1);
		$this->db->order_by('up.user_full_name ASC, uc.user_full_name ASC');
		$results = $this->db->get($this->_tableName);
		return $results->row();
	}
}