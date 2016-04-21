<?php
/**
 * parenting.php Controller Class.
 */
class Parenting extends Application {

	public $ret = "";

	function __construct(){
		parent::__construct();
		$this->load->model("parentsclass");
		$this->load->library('pagination');

		$this->ret['ret'] = "ret=admin/parenting";
		$this->record_count = 0;
	}

	function saveUserParent()
	{
		$rec = $_POST['user_info'];

		if( isset( $rec['password'] ) && $rec['password'] != '' )
		{
			$rec['user_password'] = md5( $rec['password'] );

			unset( $rec['password'] );
		}

		save_or_update("usersclass", "user_id", "Parent", set_record('user', $rec) );
		save_or_update("parentsclass", "parent_id", "Parent", set_record('parents', $rec) );
	}

	/**
	 * @param int $p: The page number.
	 * @param int $l: The max results per page.
	 *
	 * @return mixed
	 */
	function getParentsWithLogins( $p = 0, $l = 0 )
	{
		$s = "";

		if( isset( $_POST['search'] ) && strlen( $_POST['search'] ) > 0  )
		{
			$s = $_POST['search'];
		}

		$this->record_count = $this->parentsclass->getParentsCount( $s );
		$parents = $this->parentsclass->getAllParents($p, $l, $s);

		foreach( $parents as $k => &$v )
		{
			$v['logins'] = $this->usertrackingclass->countUserLogins( $v['user_id'] );
		}

		return $parents;
	}

	// Pagination.
	function pagin( $p = 1 )
	{
		$this->index( $p );
	}

	/**
	 * @param $p: The page number.
	 */
	function index( $p = 0 ){

		if( $this->reqType("POST") && isset( $_POST['user_info'] ) )
		{
			$this->saveUserParent();
		}

		// The max result per page.
		$per_page = 20;

		$this->data['pagebody']  = 'parenting';
		$this->data['pagetitle'] = 'Dragon Bank | Admin ';
		$data['parents'] 		 = $this->getParentsWithLogins( $p, $per_page );
		$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dragonbank.com/admin/parenting/pagin/';
		$config['total_rows'] 		= $this->record_count;
		$config['per_page'] 		= $per_page;
		$config['num_links'] 		= 3;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] 		= 4;

		$this->pagination->initialize($config);

		$data['pagination_links'] = $this->pagination->create_links();

		$this->load->vars( $data );
		$this->load->vars( $this->ret );

		$this->render("_template_admin");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */