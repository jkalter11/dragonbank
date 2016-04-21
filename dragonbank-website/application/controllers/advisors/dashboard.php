<?php

class Dashboard extends Application {
	
	public $ret = "";

	function __construct(){
		parent::__construct();

		$this->load->model(array('parentsclass', 'childrenclass', 'usertrackingclass'));
		//$this->load->library('pagination');

		$this->ret['ret'] = "ret=advisors/dashboard";
		$this->record_count = 0;
	}

	/**
	 * @param $p: The page number.
	 */
	function index() {

		$this->data['pagebody']  = 'advisors/dashboard';
		$this->data['pagetitle'] = 'Dragon Bank | Advisors - Welcome';
		$this->data['pageheading'] = 'My Dashboard';

		$this->data['childrencount'] = 0;
		$this->data['malecount'] = 0;
		$this->data['femalecount'] = 0;
		$this->data['averageage'] = 0;
		$this->data['logincount'] = 0;
		$this->data['averagelogins'] = 0;
		$this->data['totalweeklyallowance'] = 0;
		$this->data['totalmonthlyallowance'] = 0;
		$this->data['averagetimeloggedin'] = 0;
		$this->data['averagespendamount'] = 0;
		$this->data['averagesaveamount'] = 0;
		$this->data['averagegiveamount'] = 0;
		$this->data['averageallowancepaid'] = 0;

		$this->data['totalmain'] = 0;
		$this->data['totalspendamount'] = 0;
		$this->data['totalsaveamount'] = 0;
		$this->data['totalgiveamount'] = 0;
		$this->data['totalimpressions'] = 0;
		$this->data['totalbirthdays'] = 0;
		$this->data['totalbalance'] = 0;

		$parents = $this->parentsclass->getParentsByAdvisorID($this->session->userdata('type_id'));

		$this->data['parentcount'] = count($parents);



		foreach ($parents as $p)
		{
			$loginCount = $this->usertrackingclass->countUserLogins($p->parent_user_id);
			$this->data['logincount'] += $loginCount;

			$children = $this->childrenclass->getChildInfoByParent($p->parent_id);
			$this->data['childrencount'] += count($children);

			$loginData = $this->usertrackingclass->getLoginsByUserID($p->parent_user_id);

			if (count($loginData))
			{
				foreach ($loginData as $ld)
				{
					$this->data['averagetimeloggedin'] += $ld->logged_out - $ld->logged_in;
				}
			}

			if (count($children))
			{
				foreach ($children as $c)
				{
					$loginCount = $this->usertrackingclass->countUserLogins($c['user_id']);
					$this->data['logincount'] += $loginCount;

					if (strtolower($c['gender']) == 'male')
					{
						$this->data['malecount']++;
					}
					else if (strtolower($c['gender']) == 'female')
					{
						$this->data['femalecount']++;
					}

					if (strtolower($c['allowance_frequency']) == 'week')
					{
						$this->data['totalweeklyallowance'] += $c['allowance'];
					}
					else if (strtolower($c['allowance_frequency']) == 'month')
					{
						$this->data['totalmonthlyallowance'] += $c['allowance'];
					}

					$this->data['averagespendamount'] += $c['spend_amount'];
					$this->data['averagesaveamount'] += $c['save_amount'];
					$this->data['averagegiveamount'] += $c['give_amount'];
					$this->data['averageallowancepaid'] += $c['allowance'];

					$this->data['totalbalance'] += $c['balance'];

					$from = new DateTime($c['birthday']);
					$to = new DateTime('today');

					if ($from->format('m') == $to->format('m'))
					{
						$this->data['totalbirthdays']++;
					}

					$this->data['averageage'] += $from->diff($to)->y;

					$loginData = $this->usertrackingclass->getLoginsByUserID($c['user_id']);

					if (count($loginData))
					{
						foreach ($loginData as $ld)
						{
							$this->data['averagetimeloggedin'] += $ld->logged_out - $ld->logged_in;
						}
					}
				}
			}
		}

		if ($this->data['logincount'] > 0)
		{
			$this->data['averagetimeloggedin'] /= $this->data['logincount'];
		}
		$this->data['averagetimeloggedin'] = gmdate("H:i:s", $this->data['averagetimeloggedin']);

		if ($this->data['childrencount'] > 0)
		{
			$this->data['averageage'] = number_format($this->data['averageage'] / $this->data['childrencount'], 2);
		}

		if ($this->data['parentcount'] > 0 || $this->data['childrencount'] > 0)
		{
			$this->data['averagelogins'] = number_format($this->data['logincount'] / ($this->data['parentcount'] + $this->data['childrencount']), 2);
		}
		
		$this->data['totalweeklyallowance'] = number_format($this->data['totalweeklyallowance'] , 2);
		$this->data['totalmonthlyallowance'] = number_format($this->data['totalmonthlyallowance'], 2);

		$this->data['totalspendamount'] = number_format($this->data['averagespendamount']);
		$this->data['totalsaveamount'] = number_format($this->data['averagesaveamount']);
		$this->data['totalgiveamount'] = number_format($this->data['averagegiveamount']);
		$this->data['totalbalance'] = number_format($this->data['totalbalance']);


		if ($this->data['childrencount'] > 0)
		{
			$this->data['averagespendamount'] = number_format($this->data['averagespendamount'] / $this->data['childrencount'], 2);
			$this->data['averagesaveamount'] = number_format($this->data['averagesaveamount'] / $this->data['childrencount'], 2);
			$this->data['averagegiveamount'] = number_format($this->data['averagegiveamount'] / $this->data['childrencount'], 2);
			$this->data['averageallowancepaid'] = number_format($this->data['averageallowancepaid'] / $this->data['childrencount'], 2);
		}

		// get impressions
		$query = "SELECT COUNT(id) impressions FROM impressions WHERE advisor_id = ?";
		$result = $this->db->query($query, array($this->session->userdata('type_id')));
		$result = $result->row();

		$this->data['totalimpressions'] = $result->impressions;






		//$this->data['typeData'] = $this->session->userdata('typeData');
		//$data['addJS']			 = "jquery.validate.min.js, validateForm.js"; // Gets loaded in _template_admin.php

		$config['base_url'] 		= 'http://dev.dragonbank.com/advisors/dashboard/';

		//$this->load->vars($data);
		$this->load->vars($this->ret);
		
		$this->render("advisors/_template");
	}
}

/* End of file parenting.php */
/* Location: ./application/controllers/parenting.php */