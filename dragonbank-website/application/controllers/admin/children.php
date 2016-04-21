<?php
/**
 * children.php Controller Class.
 */
class Children extends Application {

	public $ret = "";

	function __construct(){
		parent::__construct();

		$this->load->model( array("parentsclass", "childrenclass") );
		$this->load->library('pagination');

		$this->ret['ret'] = "ret=admin/children";
		$this->record_count = "";
	}

	function saveUserChild()
	{
		$rec = $_POST['user_info'];

		if( isset( $rec['password'] ) && $rec['password'] != '' )
		{
			$rec['user_password'] = md5( $rec['password'] );

			unset( $rec['password'] );
		}

		save_or_update("usersclass", "user_id", "Children", set_record('user', $rec) );
		save_or_update("childrenclass", "child_id", "Children", set_record('children', $rec) );
	}

	function getChildren(  $p = 0, $l = 0  )
	{
		$pid 		= 0; // Parent ID.
		$children 	= array();

		if( isset( $_GET['parent_id'] ) )
		{
			$pid = (int)$_GET['parent_id'];
		}

		// Either gets parent's children or all children.
		if( $pid === 0 )
		{
			$s = "";

			if( isset( $_POST['search'] ) && strlen( $_POST['search'] ) > 0  )
			{
				$s = $_POST['search'];
			}

			$this->record_count = count($this->childrenclass->getChildrenCount( $s ));
			$children = $this->childrenclass->getAllChildren( $p, $l, $s );
		}
		else
		{
			$children 	= $this->childrenclass->getChildInfoByParent( $pid );
			$this->ret['ret'] .= "?parent_id=".$pid;
		}



		return $children;
	}

	// Pagination.
	function pagin( $p = 1 )
	{
		$this->index( $p );
	}

	function index( $p = 0 ){

		if( $this->reqType("POST") && isset( $_POST['user_info'] ) )
		{
			$this->saveUserChild();
		}

		// The max result per page.
		$per_page = 20;

		$this->data['pagebody']  = 'children';
		$this->data['pagetitle'] = 'Dragon Bank | Admin ';

		// Returns Children data array or empty array.
		$data['children'] = $this->getChildren( $p, $per_page );

		$config['base_url'] 		= 'http://dragonbank.com/admin/children/pagin/';
		$config['total_rows'] 		= $this->record_count;
		$config['per_page'] 		= $per_page;
		$config['num_links'] 		= 3;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] 		= 4;

		$this->pagination->initialize($config);

		$data['pagination_links'] = $this->pagination->create_links();

		$data['addJS'] = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$this->load->vars( $data );
		$this->load->vars( $this->ret );

		$this->render("_template_admin");
	}
}

/* End of file children.php */
/* Location: ./application/controllers/children.php */