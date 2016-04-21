<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ajax_history.php Controller Class.
 */
class Ajax_history extends Application {

    function __construct(){
        parent::__construct();
		
		$this->load->model( "historyclass" );
    }
	
	function index() {
		
		$cid = 0; 
		
		$data['status'] = TRUE;
		
		if( isset($_GET['history_child_id'] ) && '' != $_GET['history_child_id'] ){
			$cid = $_GET['history_child_id'];
		} else {
			$data['status'] = FALSE;
		}
		
		$data['history'] = $this->historyclass->getHistory( $cid );
		
		echo json_encode( $data );
    }
}

/* End of file ajax_history.php*/
/* Location: ./application/controllers/ajax_history.php*/