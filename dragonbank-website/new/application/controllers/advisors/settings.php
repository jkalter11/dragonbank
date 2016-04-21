<?php

class Settings extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		$this->load->model(array("usersclass", "advisorsclass", "companiesclass", "provincesclass"));
		//$this->load->helper('advisor_messaging');
		//$this->load->library('pagination');

		$this->ret['ret'] = "ret=advisors/settings";
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
			exit;
		}
		else
		{
			
			$fileinfo = $this->upload->data();
			
			$config = array();
			
			$config['image_library'] 	= 'gd2';
			$config['source_image']		= ROOT_FILE_PATH . "/data/temp/" . $fileinfo['file_name'];
			$config['new_image'] = ROOT_FILE_PATH . "/data/profile/advisors/";
			$config['maintain_ratio'] 	= TRUE;
			$config['width']	 		= 105;
			$config['height']			= 135;
			
			$this->load->library('image_lib', $config); 
			
			$this->image_lib->resize();
			
			return $fileinfo['file_name'];
		}
		
    }

	/**
	 * @param $p: The page number.
	 */
	function index() {

		redirect('/advisors/settings/profile/');

		$this->data['pagebody']  = 'advisors/settings';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - Settings';
		$this->data['pageheading'] = 'Settings';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/clients/';


		//$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}

	public function profile()
	{
		$provinceData = $this->provincesclass->getProvinces();
		$typeData = $this->advisorsclass->getAdvisorByUserID($this->session->userdata('user_id'));
		$userData = $this->usersclass->getUser($this->session->userdata('user_id'));
		$companyData = $this->companiesclass->getCompanyByAdvisorID($typeData->id);

		$fullname = explode(' ', $userData->user_full_name);

		//var_dump($this->session->all_userdata());
		//exit;
		$data['firstname'] = $fullname[0];
		$data['lastname'] = $fullname[1];
		$data['position'] = $typeData->position;
		$data['company'] = $companyData->name;
		$data['address1'] = $typeData->address1;
		$data['address2'] = $typeData->address2;
		$data['city'] = $typeData->city;
		$data['province_id'] = $typeData->province_id;
		$data['postalcode'] = $typeData->postalcode;
		$data['user_phone'] = $userData->user_phone;
		$data['fax'] = $typeData->fax;
		$data['cell'] = $typeData->cell;
		$data['user_name'] = $userData->user_name;
		$data['user_email'] = $userData->user_email;
		$data['provinces'] = $provinceData;
		$data['photo'] = $typeData->photo;
		//$data['password'];


		// this is so bad...
		if (isset($_POST['save']))
		{
			$errors = array();
			// userdata

			$usernewdata = array();
			$advisornewdata = array();

			foreach ($_POST['userdata'] as $k => $v)
			{
				$usernewdata[$k] = $data[$k] = $v;
				
			}

			foreach ($_POST['advisordata'] as $k => $v)
			{
				$advisornewdata[$k] = $data[$k] = $v;
			}


			if (empty($data['firstname']))
			{
				$errors['firstname'] = 'First name is blank';
			}

			if (empty($data['lastname']))
			{
				$errors['lastname'] = 'Last name is blank';
			}

			if (empty($data['address1']))
			{
				$errors['address1'] = 'Address 1 is blank';
			}

			if (empty($data['city']))
			{
				$errors['city'] = 'City is blank';
			}

			if (empty($data['postalcode']))
			{
				$errors['postalcode'] = 'Postal code is blank';
			}

			if (empty($data['user_phone']))
			{
				$errors['user_phone'] = 'Office phone is blank';
			}

			if ($data['user_email'] != $userData->user_email)
			{
				if ($data['user_email'] != $_POST['confirm_email'])
				{
					$errors['user_email'] = 'Email does not match';
				}
			}

			if (strlen($data['user_password']))
			{
				if ($data['user_password'] != $_POST['confirm_password'])
				{
					$errors['user_password'] = 'Password does not match';
				}
				else if (strlen($data['user_password']) < 6)
				{
					$errors['user_password'] = 'Password is less than 6 characters';
				}
			}


			if (empty($errors))
			{

				if (isset($_FILES['photo']) && $_FILES['photo']['size'])
				{
					$advisornewdata['photo'] = $this->uploadImage('photo');

					if ($typeData->photo != 'default.png')
					{
						unlink(ROOT_FILE_PATH . "/data/profile/advisors/" . $typeData->photo);
					}
			
				}


				$usernewdata['user_full_name'] = $usernewdata['firstname'] . ' ' . $usernewdata['lastname'];
				unset($usernewdata['firstname'], $usernewdata['lastname']);

				if (strlen($usernewdata['user_password']) > 5)
				{
					$usernewdata['user_password'] = md5($usernewdata['user_password']);
				}
				else
				{
					unset($usernewdata['user_password']);
				}
				

				$this->db->where('user_id', $userData->user_id);
				$this->db->update('users', $usernewdata);

				$this->db->where('id', $typeData->id);
				$this->db->update('advisors', $advisornewdata);	

				$this->session->set_userdata(array( 
					'user_name'		=> $usernewdata['user_full_name'],
					'name_email' 	=> $usernewdata['name_email'],
					'phone' => $usernewdata['user_phone']
				));

				$typeData2 = $this->advisorsclass->getAdvisorByUserID($this->session->userdata('user_id'));

				$this->session->set_userdata('typeData', (array) $typeData2);

				set_message("<strong>Success</strong> Your profile has been updated", 'alert-success');
				redirect('/advisors/settings/profile');
			}
			else
			{
				$data['error_vars'] = $errors;
				set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger');
			}

		}


		$this->data['pagebody']  = 'advisors/profile';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - Settings - Profile';
		$this->data['pageheading'] = 'Settings: My Profile';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/settings/profile';

		$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */