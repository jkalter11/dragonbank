<?php

class Companies extends Application {
	
	public $ret = "";

    function __construct(){
        parent::__construct();

		$this->load->model("companiesclass");
		$this->load->library(array('pagination'));

		$this->ret['ret'] = "ret=admin/companies";
		$this->record_count = 0;
    }


    function uploadImage($field = '')
    {
		
		$config['upload_path']   	=   ROOT_FILE_PATH . "/data/temp/";
		$config['allowed_types'] 	=   "gif|jpg|jpeg|png"; 
		$config['max_size']      	=   "5000";
		$config['encrypt_name'] = TRUE;
		
		$this->load->library('upload', $config);
		
		if (!$this->upload->do_upload($field))
		{
			echo $this->upload->display_errors();
		}
		else
		{
			
			$fileinfo = $this->upload->data();
			
			$config = array();
			
			$config['image_library'] 	= 'gd2';
			$config['source_image']		= ROOT_FILE_PATH . "/data/temp/" . $fileinfo['file_name'];
			$config['new_image'] = ROOT_FILE_PATH . "/data/profile/companies/";
			$config['maintain_ratio'] 	= TRUE;
			$config['width']	 		= 200;
			$config['height']			= 150;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
			return $fileinfo['file_name'];
		}
		
    }

	
	function save()
	{
		$rec = $_POST['company'];


		if (isset($_FILES['logo']) && $_FILES['logo']['size'])
		{
			$rec['logo'] = $this->uploadImage('logo');
		}

		
		if (isset($rec['id']))
		{
			$id = $rec['id'];
			unset($rec['id']);
			if (isset($rec['logo']) && !empty($rec['logo']))
			{
				$query = "SELECT logo FROM companies WHERE id = ?";
				$result = $this->db->query($query, array($id));
				$companydata = $result->row();
				unlink(ROOT_FILE_PATH . "/data/profile/companies/" . $companydata->logo);
			}

			$this->db->where('id', $id);
			$this->db->update('companies', $rec);
			redirect('/admin/companies/pagin');
		}
		else
		{

			$this->db->insert('companies', $rec);

			redirect('/admin/companies/pagin');
		}

		
		//save_or_update("usersclass", "user_id", "Parent", set_record('user', $rec) );
		//save_or_update("parentsclass", "parent_id", "Parent", set_record('parents', $rec) );
	}
	

	/**
	 * @param int $p: The page number.
	 * @param int $l: The max results per page.
	 *
	 * @return mixed
	 */
	function getCompanies( $p = 0, $l = 0 )
	{
		$s = "";

		$this->load->model('regionaldirectorsclass');

		if(isset($_POST['search']) && strlen($_POST['search']) > 0)
		{
			$s = $_POST['search'];
		}

		$this->record_count = $this->companiesclass->size();
		$companies = $this->companiesclass->queryAll();
		$companies = $companies->result_array();

		foreach ($companies as $k => &$v)
		{
			$rd = $this->companiesclass->getRegionalDirectors($v['id']);
			$v['directorCount'] = $rd->num_rows();
			$v['advisorCount'] = 0;

			foreach ($rd->result() as $row)
			{
				$advisors = $this->regionaldirectorsclass->getAdvisors($row->id);
				$v['advisorCount'] += $advisors->num_rows();
			}
		}
		/*
		foreach( $parents as $k => &$v )
		{
			//$v['logins'] = $this->usertrackingclass->countUserLogins( $v['user_id'] );
		}
		*/
		return $companies;
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
	
		if( $this->reqType("POST") && isset($_POST['company']))
		{
			$this->save();
		}

		// The max result per page.
		$per_page = 20;

		$this->data['pagebody']  = 'companies';
        $this->data['pagetitle'] = 'Dragon Bank | Admin ';
		$data['companies'] 		 = $this->getCompanies($p, $per_page);
		$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dragonbank.com/admin/companies/pagin/';
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