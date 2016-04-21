<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_checkusername extends Application {

	function __construct() {
		parent::__construct();
	}
	
	private function checkChildUsername( $id, $username )
	{
		$where = array( "user_name" => $username, "user_id" => $id );
		
		// Double negative returns actual boolean.
		return ! ( ! $this->usersclass->getOneWhere( $where, NULL, "user_id") );
	}
	
	function index() {
		
		if( isset($_GET['username'] ) && '' != $_GET['username'] )
		{
			$username = trim($_GET['username']);
		}
		else 
		{
			$status = FALSE;
			echo json_encode($data['status']);
			exit();
		}
		
		if( isset( $this->sud->user_name ) && strcasecmp($this->sud->user_name, $username) == 0 )
		{
			$status = TRUE;
			echo json_encode($status);
			exit();
		}
		
		// Is the username based on the child_user_id equal to the username being checked?
		// If it is, it means the child user name is not being changed and should return true.
		if( isset( $_GET['child_user_id'] ) && $this->checkChildUsername( ( (int)$_GET['child_user_id'] ), $username ) )
		{
			$status = TRUE;
			echo json_encode($status);
			exit();
		}
		
		$unique = ! $this->usersclass->fieldExists( "user_name", $username );

		if( $unique )
		{
			// If the code is active and has not been used.
			$status = TRUE;
		}
		else
		{
			$status = FALSE;
		}

		echo json_encode($status);
		exit();
    }
}