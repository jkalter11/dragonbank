<?php

class Order extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		//$this->load->model("advisorsclass");
		//$this->load->library('pagination');

		$this->ret['ret'] = "ret=advisors/order";
		$this->record_count = 0;
	}

	public function orderSendEmail()
	{

		sendNotification("Order Request from Advisor: " . $this->session->userdata('user_name'), sendOrderEmail($_POST), $this->session->userdata("name_email"));

		set_message("<strong>Sucess</strong> Your order form has been submitted", 'alert-success');
		redirect('/advisors/order');
	}

	/**
	 * @param $p: The page number.
	 */
	function index() {

		if (isset($_POST['ordersend']))
		{
			$this->orderSendEmail();
		}

		$this->data['pagebody']  = 'advisors/order';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - Order';
		$this->data['pageheading'] = 'Order More Banks';
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/order/';

		//$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */