<?php

class Advisors extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		$this->load->model(array("advisorsclass", 'regionaldirectorsclass', 'provincesclass'));
		$this->load->library('pagination');

		$this->ret['ret'] = "ret=admin/advisors";
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
			$config['new_image'] = ROOT_FILE_PATH . "/data/profile/advisors/";
			$config['maintain_ratio'] 	= TRUE;
			$config['width']	 		= 200;
			$config['height']			= 150;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
			return $fileinfo['file_name'];
		}
		
    }

	public function save()
	{
		$user = $_POST['user'];
		$advisor = $_POST['advisor'];

		
		if (isset($user['user_password']) && $user['user_password'] != '' && $_POST['confirm_password'] == $user['user_password'])
		{
			$pwForEmail = $user['user_password'];
			$user['user_password'] = md5($user['user_password']);
			 
		}
		else
		{
			unset($user['user_password']);
		}

		if (isset($_FILES['photo']) && $_FILES['photo']['size'])
		{
			$advisor['photo'] = $this->uploadImage('photo');
		}

		
		if (isset($user['user_id']))
		{
			$id = $user['user_id'];
			$aid = $advisor['id'];

			unset($user['user_id']);
			unset($advisor['id']);


			if (isset($advisor['photo']) && !empty($advisor['photo']))
			{
				$query = "SELECT photo FROM advisors WHERE id = ?";
				$result = $this->db->query($query, array($id));
				$advisordata = $result->row();
				unlink(ROOT_FILE_PATH . "/data/profile/advisors/" . $advisordata->photo);
			}
	

			$this->db->where('user_id', $id);
			$this->db->update('users', $user);


			$this->db->where('id', $aid);
			$this->db->update('advisors', $advisor);


			redirect('/admin/advisors/pagin');
		}
		else
		{
			$user['user_group'] = 5;
			$user['registration_date'] = date('Y-m-d');

			$this->db->insert('users', $user);

			$advisor['user_id'] = $this->db->insert_id();

			$this->db->insert('advisors', $advisor);

			// email here
			if (isset($pwForEmail))
			{
				$user['pwForEmail'] = $pwForEmail;
			}
			sendNotification("Your Dragon Bank Advisor Acount Is Active!", advisorSignup($user, $advisor), $user['user_email']);


			redirect('/admin/advisors/pagin');
		}
	}

	/**
	 * @param int $p: The page number.
	 * @param int $l: The max results per page.
	 *
	 * @return mixed
	 */
	function getAdvisors( $p = 0, $l = 0 )
	{
		$rdid = isset($_GET['regional_director_id']) ? (int)$_GET['regional_director_id'] : 0;
		$cid = isset($_GET['company_id']) ? (int)$_GET['company_id'] : 0;
		$advisors = array();
		$s = "";

		if ($rdid === 0 && $cid === 0)
		{
			if(isset($_POST['search']) && strlen($_POST['search']) > 0)
			{
				$advisors = $this->advisorsclass->searchAdvisorsByName($_POST['search']);
			}
			else
			{
				$this->record_count = $this->advisorsclass->size();
				$advisors = $this->advisorsclass->getAdvisors($p, $l);
			}

		}
		else if ($cid !== 0)
		{
			$advisors = $this->advisorsclass->getAdvisorsByCompany($cid);
			$this->ret['ret'] .= "?company_id=" . $rdid;
		}
		else
		{
			$advisors = $this->advisorsclass->getAdvisorsByRD($rdid);
			$this->ret['ret'] .= "?regional_director_id=" . $rdid;
		}
		
		return $advisors->result_array();
	}

	// Pagination.
	function pagin( $p = 1 )
	{
		$this->index( $p );
	}

	/**
	 * @param $p: The page number.
	 */
	function index( $p = 0 ) {
	
		if( $this->reqType("POST") && isset( $_POST['user']))
		{
			$this->save();
		}

		// The max result per page.
		$per_page = 20;

		$this->data['pagebody']  = 'advisors';
		$this->data['pagetitle'] = 'Dragon Bank | Admin ';
		$data['advisors'] 		 = $this->getAdvisors($p, $per_page);
		$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dragonbank.com/admin/advisors/pagin/';
		$config['total_rows'] 		= $this->record_count;
		$config['per_page'] 		= $per_page;
		$config['num_links'] 		= 3;
		$config['use_page_numbers'] = TRUE;
		$config['uri_segment'] 		= 4;

		$this->pagination->initialize($config);

		$data['pagination_links'] = $this->pagination->create_links();

		$d = $this->regionaldirectorsclass->getAvailableDirectors();
		$data['regionaldirectors'] = $d->result();
		$data['provinces'] = $this->provincesclass->getProvinces();

		$this->load->vars( $data );
		$this->load->vars( $this->ret );
		
		$this->render("_template_admin");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */