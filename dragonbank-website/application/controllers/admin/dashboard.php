<?php
/**
 * dashboard.php Controller Class.
 */
class Dashboard extends Application {

    function __construct(){
        parent::__construct();
		$this->load->model( array('usersclass', 'childrenclass') );
		date_default_timezone_set('America/Vancouver');
    }
	
	function getTotalMoney()
	{
		return $this->childrenclass->getTotalAmount();
	}
	
	function getMonthRegistrations()
	{
		$first = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y") ) );
		$last = date('Y-m-t', mktime(0, 0, 0, date("m"), 1, date("Y") ) );
		
		return $this->usersclass->countMonthRegistration( $first, $last );
	}
    
	function getTodaysRegistrations()
	{
		return $this->usersclass->countTodaysRegistration();
	}
	
    function index(){
        $this->data['pagebody']  = 'dashboard';
        $this->data['pagetitle'] = 'Dragon Bank | Dashboard ';
		
		$data['amount'] = $this->getTotalMoney();
		$data['month']	= $this->getMonthRegistrations();
		$data['today']	= $this->getTodaysRegistrations();
		
		$this->load->vars($data);
		
        $this->render("_template_admin");
    }
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */