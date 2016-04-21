<?php
/**
 * statistics.php Controller Class.
 */
class Statistics extends Application {

	function __construct(){
		ini_set("display_errors", "1");
		parent::__construct();
		$this->load->model( array('usersclass', 'childrenclass', 'parentsclass', 'usertrackingclass') );
		date_default_timezone_set('America/Vancouver');
	}

	function getTotalMoney()
	{
		return $this->childrenclass->getTotalAmount();
	}

	function getMonthRegistrations()
	{
		$first = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y") ) );
		$last = date('Y-m-t', mktime(0, 0, 0, date("m"), 1, date("y") ) );

		return $this->usersclass->countMonthRegistration( $first, $last );
	}

	function getTodaysRegistrations()
	{
		return $this->usersclass->countTodaysRegistration();
	}

	function getTotalParents()
	{
		return count( $this->parentsclass->getAllParents() );
	}

	function getTotalKids()
	{
		return count( $this->childrenclass->getAllChildren() );
	}

	function getAverageAge()
	{
		$dob 		= $this->childrenclass->getAllAges();
		$totalAges 	= 0;

		foreach( $dob as $k => $v )
		{
			$age = floor( (strtotime(date('Y-m-d')) - strtotime($v['birthday'])) / 31556926);

			$totalAges 	+= $age;
		}

		$dob_total = count( $dob );

		return ( $dob_total > 0 )? ( intval(round( ( $totalAges / $dob_total )  ) ) ) : 0;
	}

	function getAvgLogins()
	{
		$logs = $this->usertrackingclass->countLogins("id");
		$users= $this->usertrackingclass->countLogins("DISTINCT user_id");

		return ( $logs > 0 )? intval( round( $logs / $users ) ) : 0;
	}

	function getAvgTimeLoggedIn()
	{
		$users 	= $this->usertrackingclass->getLoginDurations();
		$total 	= 0;
		$num	= count($users);

		foreach( $users as $k => $v )
		{
			$total += $v['DURATION'];
		}

		$avg = ( $num > 0 )?intval(round($total / $num)) : 0;

		$d = $avg / 86400 % 7;
		$h = $avg / 3600 % 24;
		$m = $avg / 60 % 60;
		$s = $avg % 60;

		$d = ( $d > 0 )? $d . " days" : "";
		$h = ( $h > 0 )? $h . " hrs" : "";
		$m = ( $m > 0 )? $m . " mins" : "";
		$s = ( $s > 0 )? $s . " secs" : "0 secs";

		return "{$d} {$h} {$m} {$s}";
	}


	function getHistoricalLogins()
	{
		$logs = $this->usertrackingclass->getAll();

		$t = array(
			'Jan' => array("Logins" => 0),
			'Feb' => array("Logins" => 0),
			'Mar' => array("Logins" => 0),
			'Apr' => array("Logins" => 0),
			'May' => array("Logins" => 0),
			'Jun' => array("Logins" => 0),
			'Jul' => array("Logins" => 0),
			'Aug' => array("Logins" => 0),
			'Sep' => array("Logins" => 0),
			'Oct' => array("Logins" => 0),
			'Nov' => array("Logins" => 0),
			'Dec' => array("Logins" => 0),
		);

		foreach( $logs as $k => $v )
		{
			$m = date("M", $v->logged_in);

			++$t[ $m ]["Logins"];
		}

		return $t;
	}


	function getHistoricalRegs()
	{
		$logs = $this->usersclass->getAll();

		$t = array(
			'Jan' => array("Registrations" => 0),
			'Feb' => array("Registrations" => 0),
			'Mar' => array("Registrations" => 0),
			'Apr' => array("Registrations" => 0),
			'May' => array("Registrations" => 0),
			'Jun' => array("Registrations" => 0),
			'Jul' => array("Registrations" => 0),
			'Aug' => array("Registrations" => 0),
			'Sep' => array("Registrations" => 0),
			'Oct' => array("Registrations" => 0),
			'Nov' => array("Registrations" => 0),
			'Dec' => array("Registrations" => 0),
		);

		foreach( $logs as $k => $v )
		{
			$m = date("M", strtotime($v->registration_date));

			++$t[ $m ]["Registrations"];
		}

		return $t;
	}

	function map_history_data($a, $b)
	{
		$c = array();

		foreach( $a as $k => $v )
		{
			$c[ $k ] = array( "Logins" => $v['Logins'], "Registrations" => $b[ $k ]["Registrations"] );
		}

		return $c;
	}

	function index(){
		$this->data['pagebody']  	= 'statistics';
		$this->data['pagetitle'] 	= 'Dragon Bank | statistics ';
		$this->data['parents']		= $this->getTotalParents();
		$this->data['kids']			= $this->getTotalKids();
		$this->data['boys']			= $this->childrenclass->getTotalGender("Male");
		$this->data['girls']		= $this->childrenclass->getTotalGender("Female");
		$this->data['avg_age']		= $this->getAverageAge();
		$this->data['spend']		= number_format($this->childrenclass->getTotals("spend_amount"), 2, ".", ",");
		$this->data['save']			= number_format($this->childrenclass->getTotals("save_amount"),2 , ".", ",");
		$this->data['give']			= number_format($this->childrenclass->getTotals("give_amount"),2 , ".", ",");
		$this->data['avg_spend']	= number_format($this->childrenclass->getAverage("spend_amount"), 2, ".", ",");
		$this->data['avg_save']		= number_format($this->childrenclass->getAverage("save_amount"), 2, ".", ",");
		$this->data['avg_give']		= number_format($this->childrenclass->getAverage("give_amount"), 2, ".", ",");
		$this->data['avg_all'] 		= number_format($this->childrenclass->getAverage("allowance"), 2, ".", ",");;
		$this->data['weekly'] 		= $this->childrenclass->countAllowanceFreq("WEEK");
		$this->data['monthly'] 		= $this->childrenclass->countAllowanceFreq("MONTH");;
		$this->data['deposits'] 	= number_format($this->childrenclass->getTotals("balance"),2 , ".", ",");
		$this->data['logins']		= $this->usertrackingclass->countLogins("id");
		$this->data['avg_logins']	= $this->getAvgLogins();
		$this->data['avg_time']		= $this->getAvgTimeLoggedIn();

		$data['hist_logs']	= $this->getHistoricalLogins();
		$data['hist_regs']	= $this->getHistoricalRegs();
		$data['amount']		= $this->getTotalMoney();
		$data['month']		= $this->getMonthRegistrations();
		$data['today']		= $this->getTodaysRegistrations();

		$data["addJS"]	= array(
			"jchartfx/jchartfx.system.js",
			"jchartfx/jchartfx.coreBasic.js",
			"jchartfx/jchartfx.coreVector.js",
			"jchartfx/jchartfx.coreVector3d.js",
			"jchartfx/jchartfx.advanced.js",
			"jchartfx/jchartfx.ui.js"
		);
		$data['addCSS']	= array(
			"jchartfx.css",
			"sample.css",
		);

		$this->load->vars($data);

		$this->render("_template_admin");
	}
}

/* End of file statistics.php */
/* Location: ./application/controllers/statistics.php */