<?php
/**
 * history.php Controller Class.
 */
class History extends Application {
	
	private $vars;

    function __construct(){
        parent::__construct();
		
		$this->load->model(array("childrenclass", "historyclass"));
		
		$this->vars = array("get" => "", "export" => "");
		
		if( isset( $_GET['h'] ) )
		{
			$this->vars = array("get" => "", "export" => "?h=".$_GET['h']);
		}
    }
	
	/**
	 * Validates the user when there is a $_GET request to the profile page
	 * to protect profiles from all other users accept the child's parents and the child.
	 *
	 * @param  $cid: The child's id. 	 
	 */
	private function validateProfileUser( $cid )
	{
		// Make sure the user_group has been set.
		if( ( $ug = (int)$this->sud->user_group ) == 0)
		{
			return FALSE;
		}
		
		// Make sure the parent_id or child id has been set.
		if( ( $ug == 2 && $this->sud->type_id <= 0 ) || ( $ug == 3 && $this->sud->type_id <= 0 ) )
		{
			return FALSE;
		}
		
		// Returns true if the the parent is the childs parent or
		// the $_GET request child ID matches the logged in child.
		return ( ( $ug == 2 && isParent( $cid ) ) || ( $ug == 3 && $this->sud->type_id == $cid ) );
	}
	
    public function getChild()
	{
		// If parent has specified a child.
		if( isset( $_GET['child_id'] ) && (int)$_GET['child_id'] > 0 && $this->sud->user_group == 2 )
		{
			$child_id = (int)$_GET['child_id'];
			
			if( $this->validateProfileUser( $child_id ) === FALSE )
			{
				flash_redirect("new/login", status("", "You do not have permission to view that page", "red"), "login_flash");
			}
			
			if( $this->vars['get'] == "" )
			{
				// Used to set the anchors if a parent is logged in.
				$this->vars['get'] = "?child_id=$child_id";
			}
			else
			{
				// Used to set the anchors if a parent is logged in.
				$this->vars['get'] .= "&child_id=$child_id";
			}
			
			if( $this->vars['export'] == "" )
			{
				$this->vars['export'] = "?child_id=$child_id";
			}
			else
			{
				$this->vars['export'] .= "&child_id=$child_id";
			}
			
			return $this->childrenclass->getChild($child_id);
		}
		
		// A child is logged in, so use session.
		return $this->childrenclass->getChild($this->sud->type_id);
	}
	
	private function setSpendHistory( $history )
	{
		$temp = array();

		foreach( $history as $k => $h )
		{
			if( $h['spend_history'] == 0.00 )
			{
				continue;
			}
			
			$a = array( 
				"money" 		=> $h['spend_history'], 
				"transaction" 	=> $h['transaction'],
				"desc" 			=> $h['desc'],
				"balance" 		=> $h['spend_balance'],
				"date"			=> $h['date'],
				"minus"			=> FALSE
			);
			
			if( $h['debit'] > 0.00 )
			{
				$a['minus'] = TRUE;
			}
			
			$temp[] = $a;
		}

		return $temp;
	}
	
	private function setSaveHistory( $history )
	{
		$temp = array();
		foreach( $history as $k => $h )
		{
			if( $h['save_history'] == 0.00 )
			{
				continue;
			}
			
			$a = array( 
				"money" 		=> $h['save_history'], 
				"transaction" 	=> $h['transaction'],
				"desc" 			=> $h['desc'],
				"balance" 		=> $h['save_balance'],
				"date"			=> $h['date'],
				"minus"			=> FALSE
			);
			
			if( $h['debit'] > 0.00 )
			{
				$a['minus'] = TRUE;
			}
			
			$temp[] = $a;
		}
		
		return $temp;
	}
	
	private function setGiveHistory( $history )
	{
		$temp = array();

		foreach( $history as $k => $h )
		{
			if( $h['give_history'] == 0.00 )
			{
				continue;
			}
			
			$a = array( 
				"money" 		=> $h['give_history'], 
				"transaction" 	=> $h['transaction'],
				"desc" 			=> $h['desc'],
				"balance" 		=> $h['give_balance'],
				"date"			=> $h['date'],
				"minus"			=> FALSE
			);
			
			if( $h['debit'] > 0.00 )
			{
				$a['minus'] = TRUE;
			}
			
			$temp[] = $a;
		}
		
		return $temp;
	}
	
	private function setHistory( $history )
	{	
		foreach( $history as $k => $h )
		{
			$a = array( 
				"money" 		=> ($h['credit'] > 0)? $h['credit'] : $h['debit'], 
				"transaction" 	=> $h['transaction'],
				"desc" 			=> $h['desc'],
				"balance" 		=> $h['balance'],
				"date"			=> $h['date'],
				"minus"			=> FALSE
			);
			
			if( $h['debit'] > 0.00 )
			{
				$a['minus'] = TRUE;
			}
			
			$this->vars['history'][] = $a;
		}
	}
	
	private function setHistoryNotFound()
	{	
		$this->vars['history'][] = array( 
			"money" 		=> "Not Data", 
			"transaction" 	=> "Not Data",
			"desc" 			=> "Not Data",
			"balance" 		=> "Not Data",
			"date"			=> "Not Data",
			"minus"			=> FALSE
		);	
	}
	
	/** 
     * Sets the display for the amount of the discount code to show either a percent or dollar sign.
		*
     * @param (array) $data: Using a reference to store array data.
     */
    private function createCSV( $history ){
		
		$this->load->model('childrenclass');

		$child = $this->childrenclass->getChild($_GET['child_id']);


    	// send response headers to the browser
        header( 'Content-Type: text/csv' );
        header( 'Content-Disposition: attachment;filename=' . str_replace(' ', '_',  $child[0]['user_full_name']) . '_'.date("Y_m_d").'_list.csv');
        
        $fp = fopen('php://output', 'w');
        
        fputcsv($fp, array('Date', 'Transaction', 'MoneyIn', 'MoneyOut', 'Balance', 'Desc'));
        fputcsv($fp, array('','','','','',''));
		
        foreach( $history as $k => $row ){
			
        	if( ! $row ){
        		echo 'row failed';
        		exit();
        	}
        	
			if( strcasecmp($row['transaction'], "deposit") == 0 )
			{
				$moneyin = $row['money'];
				$moneyout= 0.00;
			}
			else
			{
				$moneyin = 0.00;
				$moneyout= $row['money'];
			}
			
        	fputcsv( $fp, array( $row['date'], $row['transaction'], $moneyin, $moneyout, $row['balance'], $row['desc'] ) );
        }
		
        fclose($fp);
        
        // We need to prevent any more output from being sent to the browser.
        exit();
    }
	
	private function getHistory( $history )
	{	
		if( isset( $_GET['h'] ) )
		{
			$h = $_GET['h'];
			
			if( $h == "gi" )
			{
				$r = $this->setGiveHistory( $history );
			}
			elseif( $h == "sa" )
			{
				$r = $this->setSaveHistory( $history );
			}
			else // defaults to spend
			{
				$r = $this->setSpendHistory( $history );
			}
			
			if( ! $r )
			{
				$this->setHistoryNotFound();
			}
			else
			{
				$this->vars['history'] = $r;
			}
		}
		else
		{
			$this->setHistory( $history );
		}
		
		return true;
	}
    
	/**
	 * Instead of using index, you can use _remap.
	 * _remap will always be called first. The parameter $method can be used to call a single function.
	 * In this case, $method determines whether to call createCSV via a url segment export: dragon/profile/history/export.
	 * Otherwise, the url segment dragon/profile/history will load like function index.   	 
	 */
    function _remap( $method ){
		
		// Redirect parents to profile page unless a child is specified in the $_GET request.
		if( $this->sud->user_group == 2 && ! isset( $_GET['child_id'] ) )
		{
			redirect('new/profile/parentsprofile');
		}
		
		$child = $this->getChild();
		
		// Gets history date.
		if( $this->reqType( "GET" ) && isset( $_GET['year'] ) )
		{
			$y 	= (int)$_GET['year'];
			$m 	= (int)$_GET['month'];
			
			$this->vars['sy'] = $y;
			$this->vars['sm'] = $m;
			
			if( $this->vars['export'] == "" )
			{
				$this->vars['export'] = "?year=$y&month=$m";
			}
			else
			{
				$this->vars['export'] .= "&year=$y&month=$m";
			}
			
			if( $y == 0 )					// All dates.
			{
				$startdate 	= "2013-01-01";
				$enddate 	= 0;
			}
			elseif( $y != 0 && $m == 0 )	// All months, single year
			{
				$startdate 	= "$y-01-01";
				$enddate	= "$y-12-31";
			}
			else							// Single month, single year
			{
				$this->load->helper('date');
				$d = (int)days_in_month( $m, $y );
				$startdate	= "$y-$m-01";
				$enddate	= "$y-$m-$d";
			}
		}
		else // Defaults to current year, all months.
		{
			$startdate 	= (int)date("Y") . "-01";
			$enddate 	= 0;
		}
		
		$this->vars['start'] 	= strtotime($startdate);
		$this->vars['end']		= strtotime(($enddate===0)?"0000-12-31":$enddate);
		
		$history = $this->historyclass->searchHistory( $startdate, $enddate, $child[0]['child_id'] );
		//debug( $history );
		// If ! history, sets a data not found array.
		$this->getHistory( $history );
		
		if( $method == "export" )
		{
			$this->createCSV( $this->vars['history'] );
		}
		else
		{
			$startyear 	= 2013;
			$endyear 	= (int)date("Y"); 
			
			for( $i = $startyear; $i <= $endyear; $i++)
			{
				$this->vars['years'][] = $i;
			}
			
			$this->load->vars($child[0]);
			$this->load->vars($this->vars);
			
			$this->data['pagebody']  = 'v2/history';
			$this->data['pagetitle'] = 'Dragon Bank | History ';
			
			$this->render();
		}
    }
}

/* End of file history.php */
/* Location: ./application/controllers/history.php */
