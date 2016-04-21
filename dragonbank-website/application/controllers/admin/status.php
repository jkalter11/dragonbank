<?php
/**
 * Status controller class.
 */
class Status extends Application {
    function __construct(){
        parent::__construct();
		
		if( ! class_exists( "parentsclass" ) )
		{
			$this->load->model("parentsclass");
		}
		
		if( ! class_exists( "childrenclass" ) )
		{
			$this->load->model("childrenclass");
		}
		
    }
	
	private function hierarchy( $pid, $status )
	{
		if( $pid )
		{
			$childs_ids = $this->childrenclass->getUserIdByParentId( $pid );
			
			foreach( $childs_ids as  $k => $v )
			{
				$update = array( "user_id" => $v['child_user_id'], "status" => $status );
				
				$this->usersclass->update( $update );
			}
		}
		
		return;
	}
	
	private function parentActive( $uid )
	{
		$pid = $this->childrenclass->getParentIdByUserId( $uid );
		
		return ( (int)$this->parentsclass->getStatus( $pid ) === 1 );
	}
    
    /**
     * Perform suspend on row.
     *
     * return true if success or false on failure.
     */
    function doStatus(){
        
        /** 
         * Lets make sure YOU set the correct GET requests.
         */
        if( ! $this->reqType('GET') || ! isset( $_GET['status'] ) || ! isset( $_GET['ret'] ) )
            return false;
		
		$status = $_GET['status'];
		$ret 	= $_GET['ret'];
        
		if( isset( $_GET['parent_user_id'] ) && (int)$_GET['parent_user_id'] > 0 )
		{
			$uid = (int)$_GET['parent_user_id'];
			
			$pid = (int)$this->parentsclass->getParentIdByUserId($uid);
			
			$this->hierarchy( $pid, $status ); // Update child's status associated to parent.
		}
		elseif( isset( $_GET['child_user_id'] ) && (int)$_GET['child_user_id'] > 0 )
		{
			$uid = (int)$_GET['child_user_id'];
			
			if( ! $this->parentActive( $uid ) )
			{
				$this->go( $ret ); // do nothing if parent is not active.
			}
		}
		
		$update = array("user_id" => $uid, "status" => $status);
		
		$this->usersclass->update( $update ); // Save
		
		$this->go( $ret );
    }
	
	function go( $ret )
	{
		redirect( $ret );
		exit();
	}
    
    function index(){
        $this->doStatus();
    }
}

/* End of file suspend.php */
/* Location: ./application/controllers/suspend.php */