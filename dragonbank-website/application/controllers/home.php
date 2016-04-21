<?php
/**
 * home.php Controller Class.
 */
class Home extends Application {

    function __construct(){
        parent::__construct();
        error_reporting(-1);
        $this->load->helper(array('form', 'url'));
        $this->load->library('form_validation');
        $this->load->model('common_model');

    }
    
   function index()
   {
        $this->data['pagebody']  	= 'v2/home';
        $this->data['pagetitle'] 	= 'Dragon Bank - Save, Spend, Give';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'The Dragon Bank is a fantastic investment in your child’s financial future start saving the Dragon Way TODAY!';
        $this->render();
   }

   function login()
   {
      
      $user_name = $this->input->post('username');
      $password = $this->input->post('password');
      $this->form_validation->set_rules('username', 'Username', 'required');
      $this->form_validation->set_rules('password', 'Password', 'required');
     
      // $message1 = 'invalid login detail'; 
      // $this->session->set_flashdata('message',$message1); 
      // $this->session->set_flashdata('status','error'); 
      if ($this->form_validation->run() == FALSE)
      {
         $this->data['pagebody']    = 'v2/home';
         $this->data['pagetitle']    = 'Dragon Bank - Save, Spend, Give';
         $this->data['keys']        = 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
         $this->data['desc']        = 'The Dragon Bank is a fantastic investment in your child’s financial future start saving the Dragon Way TODAY!';
         
       
         $this->render();
      }
      else
      {
         $con = array('username'=>$user_name,'password'=>$password);
        $result = $this->common_model->get_count('login',$con)->row_array();
        if(!empty($result)){
           $this->data['mess'] = 'Login successfully';
        }else{
          $this->data['mess'] = 'Invalid login details.';
        }
          $this->data['pagebody']    = 'v2/home';
         $this->data['pagetitle']    = 'Dragon Bank - Save, Spend, Give';
         $this->data['keys']        = 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
         $this->data['desc']        = 'The Dragon Bank is a fantastic investment in your child’s financial future start saving the Dragon Way TODAY!';
        
          //echo $this->session->flashdata('success_msg');
         $this->render();
      }
      
   }
   function bank_account(){
    $bank_account = $this->input->post('code');
    $this->form_validation->set_rules('code', 'Access code', 'required');
    $con = array('access_code'=>$bank_account);
    $result = $this->common_model->get_count('bank_account',$con);
    if ($this->form_validation->run() == FALSE)
    {
         $this->data['pagebody']    = 'v2/home';
         $this->data['pagetitle']    = 'Dragon Bank - Save, Spend, Give';
         $this->data['keys']        = 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
         $this->data['desc']        = 'The Dragon Bank is a fantastic investment in your child’s financial future start saving the Dragon Way TODAY!';
         $this->render();
    }
    else
    {
          $this->data['pagebody']    = 'v2/home';
         $this->data['pagetitle']    = 'Dragon Bank - Save, Spend, Give';
         $this->data['keys']        = 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
         $this->data['desc']        = 'The Dragon Bank is a fantastic investment in your child’s financial future start saving the Dragon Way TODAY!';
         $this->render();
    }
  }
  function auto_increment(){
    //$count_amount = $this->input->post('count_amount');
    $con = array('id'=>1);
    $result = $this->common_model->get_count('auto_increament',$con)->row_array();
    $update_val = $result['increament_value'] + .27;
    $data_val = array('increament_value'=>$update_val);
    $result = $this->common_model-> update('auto_increament',$data_val,$con);
    $result1 = $this->common_model->get_count('auto_increament',$con)->row_array();
    echo $update_val = $result1['increament_value'];
    //echo $this->db->last_query();
    //exit;
  }
  function ask_question(){		
		$post = $_REQUEST;
		$this->subjectLine = 'Order Rquest for Dragon Bank Access Code';
	    	$this->sendEmailTo = 'susan@enrichedacademy.com';
		$this->sendEmailBcc = 'todd@enrichedacademy.com;kaushleshsingh@gmail.com';
	
		if(isset($post) && is_array($post) && !empty($post) ){		
			if($post['email'] != '' && $post['name'] != '' && $post['comments'] != ''  ){
				$message = $post['comments'];
				$message.=  '<br> <br>- <br>Thanks Regards <br> Dragon Bank Team';	
				// test smtp by hemant 
				$config['protocol'] = "sendmail";
				$config['smtp_host'] = "mail@samosys.com";
				$config['smtp_port'] = "2525";
				$config['smtp_timeout'] = "7";
				$config['smtp_user'] = "test@samosys.com"; 
				$config['smtp_pass'] = "test@samosys123";
				$config['charset'] = "utf-8";
				$config['mailtype'] = "html";
				$config['newline'] = "\r\n";
				$config['validation'] = TRUE;  
				$this->load->library('email');
				$this->email->initialize($config);				
				// test smtp by hemant end
				
				//$this->load->library('email');
				$this->email->from($post['email'], $post['name']);
				$this->email->to($this->sendEmailTo);
				$this->email->bcc($this->sendEmailBcc);
				$this->email->subject($this->subjectLine);
				$this->email->message($message);
				if( $this->email->send()){
					$result = $this->common_model->save('contact_details',$post);				
					$return['response'] = 'true';
					$return['message'] =  "<span style='color: green'>Thank you for Contact us.</span>";
				}else{
					$return['response'] = 'false';
					$return['message'] =  "<span style='color: red'>Failed to send email. Please try again.</span>";
				}
			}else{
				$return['response'] = 'false';
				$blank = ($post['name'] == '') ? 'Name ' : '';
				$blank .= ($post['email'] == '') ? 'Email ' : '';
				$blank .= ($post['comments'] == '') ? 'Comments' : '';
				$return['message'] =  "<span style='color: red'>Please fill $blank.</span>";
			}			
			
		}else{		
			$return['response'] = 'false';
			$return['message'] =  "<span style='color: red'>Please fill all the fields.</span>";
		}
		echo json_encode($return);
	}
  
  
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */
