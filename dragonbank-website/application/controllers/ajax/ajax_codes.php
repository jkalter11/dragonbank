<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * ajax_code.phpController Class.
 */
class Ajax_codes extends Application {

    function __construct(){
        parent::__construct();
		
		$this->load->model( array("codeslistclass", "codesclass") );
    }
	
	function index() {
		
		$start 	= 0; 
		$end 	= 0;
		$listid	= 0;
		
		$data['status'] = TRUE;
		
		if( isset($_GET['codelistname'] ) && '' != $_GET['codelistname'] ){
			$codelistname = $_GET['codelistname'];
		} else {
			$data['status'] = FALSE;
		}

		if( $_GET['startdate'] !== "" )
		{
			$start = $_GET['startdate'];
		}
		
		if( $_GET['enddate'] !== "" )
		{
			$end = $_GET['enddate'];
		}
		
		$temp = $this->codeslistclass->getIdByName( $codelistname );
		
		if( $temp ) $listid = (int)$temp;
		
		$codes = $this->codesclass->searchByDate( $start, $end, $listid, (int)$_GET['limit'], (int)$_GET['lstart'] );

		$data['codes'] 	= $codes;
		$data['pages'] 	= $codes['pages'];
		$data['list_id']= $listid;

		echo json_encode( $data );
    }
}

/* End of file ajax_code.php*/
/* Location: ./application/controllers/ajax_code.php*/