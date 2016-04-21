<?php
/**
 * Logut controller extends Application
 *
 */
 
class Logout extends Application{

    function __construct(){
        parent::__construct();
		$this->load->model( array('usertrackingclass') );
    }
	
	function index()
	{
		// Track logout time.
		$this->usertrackingclass->trackLogoutTime( $this->session->userdata("tracking_id") );

		// Destroys session.
        $this->session->sess_destroy();
		
        // Destroys all data as $this->data is a reference.
        $this->data = array();
		
        redirect( "/?go=1" );
        exit();
	}
}
/* End of file logout.php */
/* Location: ./application/controllers/logout.php */
