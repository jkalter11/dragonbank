<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ajax_checkcode extends Application {

	function __construct() {
		parent::__construct();
		$this->load->model(array('codesclass'));
	}
	
	function index() {
		
		if( isset($_GET['code'] ) && '' != $_GET['code'] )
		{
			$code = $_GET['code'];
		}
		else 
		{
			$code = 0;
			$data['checkcode'] = FALSE;
		}
		
		$id = (int)$this->codesclass->getCodeIdByName( $code );

		if( $id > 0 )
		{
			// If the code is active and has not been used.
			$data['checkcode'] = ((int)$this->codesclass->codeStatus( $id ) === 1 );
		}
		else
		{
			$data['checkcode'] = FALSE;
		}

		echo json_encode($data['checkcode']);
    }
}