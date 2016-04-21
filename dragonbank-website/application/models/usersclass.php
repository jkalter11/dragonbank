<?php

class Usersclass extends _Mymodel{

	/**
	 * Constructor to create instance of DB object
	 */
	public function __construct(){
		parent::__construct();
		$this->setTable('users','user_id');
	}
	
	// Gets group by id and returns name.
	public function getGroup($id){
		$row = $this->get($id);
		
		return $row->user_group;
	}

	private function setBaseQuery()
	{
		$this->db->select('users.*');
	}

	public function getUserByUsername($name)
	{
		$this->db->where('user_name', $name);
		$this->db->or_where('user_email', $name);
		$result = $this->db->get($this->_tableName);
		if ($result->num_rows() == 1)
		{
			return $result->row();
		}
		return null;
	}

	
	// Gets status.
	public function getStatus($id){

		return (int)$this->getOneWhere("user_id", (int)$id, "status");
	}
	
	function getUser( $user_id ){
		return $this->getOneWhere('user_id', $user_id);
	}
	
	// Is this id an admins id?
	function isAdmin( $id ){
		return $this->getJoin_array('user_groups', 'user_group = group_id WHERE user_id ='.$id.' AND `group_name` = "Super User"', 'group_name');
	}
	
	function getId( $email ){
		return $this->getOneWhere('user_email', htmlspecialchars( $email ), 'user_id' );
	}
	
	function getGroupIdByName( $name ){
		$this->setTable('user_groups', 'group_id');
		
		$result = $this->getOneWhere('group_name', htmlspecialchars( $name ), 'group_id');
		
		$this->setTable('users', 'user_id');
		
		return $result;
	}
	
	public function getIdByEmail( $email ){
		return $this->getOneWhere( 'user_email', $email, 'user_id' );
	}
	
	public function countMonthRegistration( $f, $l )
	{
		$where = array("registration_date >=" => $f, "registration_date <=" => $l, "user_group =" => 3);
		
		return $this->countWhich( $where, "user_id" );
	}
	
	public function countTodaysRegistration()
	{
		$where = array("registration_date >=" => date('Y-m-d'), "user_group =" => 3);
		
		return $this->countWhich( $where, "user_id" );
	}
	
	public function getNameByEmail( $email )
	{
		return $this->getOneWhere("user_email", $email, "user_full_name");
	}
}