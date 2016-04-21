<?php

class Regionaldirectors extends Application {
	
	public $ret = "";

    function __construct(){
        parent::__construct();

		$this->load->model(array("regionaldirectorsclass", 'companiesclass'));
		$this->load->library('pagination');

		$this->ret['ret'] = "ret=admin/regionaldirectors";
		$this->record_count = 0;
    }

	
	public function save()
	{
		$user = $_POST['user'];
		$director = $_POST['director'];

		
		if( isset( $user['user_password'] ) && $user['user_password'] != '' && $_POST['confirm_password'] == $user['user_password'])
		{
			$user['user_password'] = md5($user['user_password']);
		}

		
		if (isset($user['user_id']))
		{
			$id = $user['user_id'];
			$did = $director['id'];
			unset($user['user_id']);
			unset($director['id']);

			$this->db->where('user_id', $id);
			$this->db->update('users', $user);

			if (isset($director['company_id']))
			{
				$this->db->where('id', $did);
				$this->db->update('regional_directors', $director);
			}

			redirect('/admin/regionaldirectors/pagin');
		}
		else
		{
			$user['user_group'] = 4;
			$user['registration_date'] = date('Y-m-d');

			$this->db->insert('users', $user);

			$director['user_id'] = $this->db->insert_id();

			$this->db->insert('regional_directors', $director);

			redirect('/admin/regionaldirectors/pagin');
		}
	}


	/**
	 * @param int $p: The page number.
	 * @param int $l: The max results per page.
	 *
	 * @return mixed
	 */
	function getRegionalDirectors( $p = 0, $l = 0 )
	{
		$cid = isset($_GET['company_id']) ? (int)$_GET['company_id'] : 0;
		$regionaldirectors = array();

		if($cid === 0)
		{

			if( isset( $_POST['search'] ) && strlen( $_POST['search'] ) > 0  )
			{
				$regionaldirectors = $this->regionaldirectorsclass->searchDirectorsByName($_POST['search']);
			}
			else
			{
				$this->record_count = $this->regionaldirectorsclass->size();
				$regionaldirectors = $this->regionaldirectorsclass->getDirectors($p, $l);
			}

		}
		else
		{
			$regionaldirectors 	= $this->regionaldirectorsclass->getDirectorsByCompany($cid);
			$this->ret['ret'] .= "?company_id=" . $cid;
		}

		return $regionaldirectors->result_array();
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
	
		if( $this->reqType("POST") && isset($_POST['user']))
		{
			$this->save();
		}

		// The max result per page.
		$per_page = 20;

		$this->data['pagebody']  = 'regionaldirectors';
        $this->data['pagetitle'] = 'Dragon Bank | Admin ';
		$data['directors'] 		 = $this->getRegionalDirectors($p, $per_page);
		$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dragonbank.com/admin/regionaldirectors/pagin/';
		$config['total_rows'] 		= $this->record_count;
		$config['per_page'] 		= $per_page;
		$config['num_links'] 		= 3;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] 		= 4;

		//$this->pagination->initialize($config);

		//$data['pagination_links'] = $this->pagination->create_links();

		$data['companies'] = $this->companiesclass->getActiveCompanies();

		$this->load->vars($data);
		$this->load->vars($this->ret);
		
		
		
        $this->render("_template_admin");
    }

    public function company($cid)
    {
    	echo "here";
    	exit;
    }
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */