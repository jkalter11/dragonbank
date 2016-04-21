<?php
/**
 * Deposit.php controller.
 */
class Deposit extends Application {
	
	private $vars;

    function __construct(){
        parent::__construct();
		
		$this->load->model(array("childrenclass", "historyclass"));
		
		$this->vars = array(
		    'money' => '',
		    'desc' => '',
		    "get" => '',
		    'allocation' => '1'
		);
		$this->vars['error_vars'] = array();
    }
	
	private function validateBankTransaction()
	{
		$this->vars['money'] = trim($_POST['money']);

		//echo $this->vars['money'];
		//exit;
		if (strlen($this->vars['money']) == 0)
		{
			$this->vars['error_vars']['money'] = 'Amount cannot be blank';
		}
		else if (!is_numeric($this->vars['money']))
		{
			$this->vars['error_vars']['money'] = 'Amount must be a number';
		}
		else if((float)$this->vars['money'] <= 0.00)
		{
			$this->vars['error_vars']['money'] = 'Amount cannot be 0 or a negative value';
			//flash_redirect("profile/deposit".$this->vars['get'], status("", "Amount must be greater than $0.00", "red"), "bank_transaction");
		}
		
		$this->vars['desc'] = trim($_POST['desc']);
		if(strlen($_POST['desc']) == 0)
		{
			$this->vars['error_vars']['desc'] = 'Deposit description cannot be blank';
			//flash_redirect("profile/deposit".$this->vars['get'], status("", "Please enter a reason for your deposit.", "red"), "bank_transaction");
		}


		$alloc 	= json_decode($_POST['allocation']);

		if ($alloc[0] == (float)$this->vars['default'][0] && $alloc[1] == (float)$this->vars['default'][1] && $alloc[2] == (float)$this->vars['default'][2])
		{
			$this->vars['allocation'] = 1;
		}
		else if ($alloc[0] == (float)$this->vars['spending'][0] && $alloc[1] == (float)$this->vars['spending'][1] && $alloc[2] == (float)$this->vars['spending'][2])
		{
			$this->vars['allocation'] = 2;
		}
		else if ($alloc[0] == (float)$this->vars['saving'][0] && $alloc[1] == (float)$this->vars['saving'][1] && $alloc[2] == (float)$this->vars['saving'][2])
		{
			$this->vars['allocation'] = 3;
		}
		else if ($alloc[0] == (float)$this->vars['giving'][0] && $alloc[1] == (float)$this->vars['giving'][1] && $alloc[2] == (float)$this->vars['giving'][2])
		{
			$this->vars['allocation'] = 4;
		}





		if (count($this->vars['error_vars']))
		{
			return false;
		}
		
		return TRUE;
	}
	
	private function saveHistory( $total, $sp, $sa, $gi, $cid )
	{
		$rec 	 = array();
		$account = $this->childrenclass->getAccounts( $cid );
		
		$rec['date'] 				= date("Y-m-d");
		$rec['history_child_id'] 	= $cid;
		$rec['balance']				= $this->childrenclass->getBalance( $cid );
		$rec['spend_history']		= $sp;
		$rec['save_history']		= $sa;
		$rec['give_history']		= $gi;
		$rec['spend_balance']		= (double)$account->spend_amount;
		$rec['save_balance']		= (double)$account->save_amount;
		$rec['give_balance']		= (double)$account->give_amount;
		
		if( isset( $_POST['desc'] ) )
		{
			$rec['desc'] = $_POST['desc'];
		}

		$rec['credit'] 		= (float)$total;
		$rec['transaction']	= "Deposit"; 

		setFirstDepositAchievement($cid);
		
		save_or_update("historyclass", "history_id", "", $rec);
	}
	
	private function doBankTransaction( $cid, $type )
	{
		$cc = $this->childrenclass;
		
		// We encode this value in the view.
		$alloc 	= json_decode($_POST['allocation']);
		
		// total amount.
		$total = (float)$_POST["money"];
		
		// Percent amount
		$money = (float)$_POST["money"] * 0.01;
		
		$sp = (float)$money * (float)$alloc[0];
		$sa = (float)$money * (float)$alloc[1];
		$gi = (float)$money * (float)$alloc[2];
		
		$where = array( "child_id" => $cid );

		if( $sp > 0.00 )
		{
			$cc->update($where, "spend_amount", "spend_amount$type$sp");
		}
		
		if( $sa > 0.00 )
		{
			$cc->update($where, "save_amount", "save_amount$type$sa");
		}
		
		if( $gi > 0.00 )
		{
			$cc->update($where, "give_amount", "give_amount$type$gi");
		}
		
		if( $total > 0 )
		{
			$cc->update($where, "balance", "balance$type$total");
		}
		
		$this->saveHistory( (float)$total, $sp, $sa, $gi, $cid );
		
		$total = number_format( $total, 2 );

		setAllocationAmountAchievement(4, $cid);
		setAllocationAmountAchievement(5, $cid);
		setAllocationAmountAchievement(6, $cid);
		setAllocationAmountAchievement(7, $cid);
		setAllocationAmountAchievement(8, $cid);
		setAllocationAmountAchievement(9, $cid);
		setAllocationAmountAchievement(10, $cid);
		setWishlistAchievement($cid);


		set_message("<strong>Success</strong> You have deposited " . $total, 'alert-success');
		header('Location: /new/profile/deposit' . $this->vars['get']);
		exit;
		//flash_redirect("profile/deposit".$this->vars['get'], status("", "<span style='color: black'>Deposit Amount:</span> $total", "green"), "bank_transaction");
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
		if( isset( $_GET['child_id'] ) && (int)$_GET['child_id'] > 0 && $this->sud->user_group == 2)
		{
			$child_id = (int)$_GET['child_id'];
			
			if( $this->validateProfileUser( $child_id ) === FALSE )
			{
				flash_redirect("new/login", status("", "You do not have permission to view that page", "red"), "login_flash");
			}
			
			// Used to set the anchors if a parent is logged in.
			$this->vars['get'] = "?child_id=$child_id";
			
			return $this->childrenclass->getChild($child_id);
		}
		
		// A child is logged in, so use session.
		return $this->childrenclass->getChild($this->sud->type_id);
	}
    
    function index()
    {
		$this->vars['get'] = '';
		// Redirect parents to profile page unless a child is specified in the $_GET request.
		if( $this->sud->user_group == 2 && ! isset( $_GET['child_id'] ) )
		{
			redirect('new/profile/parentsprofile');
		}

		$child = $this->getChild();
		$this->load->vars($child[0]);
		
		$this->vars['default'] 	= array( $child[0]['spend'], $child[0]['save'], $child[0]['give'] );
		$this->vars['spending'] = array(100, 0, 0);
		$this->vars['saving']	= array(0, 100, 0);
		$this->vars['giving']	= array(0, 0, 100);

		if( $this->reqType( "POST" ) )
		{
			if($this->validateBankTransaction() === FALSE)
			{
				set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger', $this->vars['error_vars']);
				//flash_redirect("profile/deposit".$this->vars['get'], status("", "Amount must be greater than $0.00", "red"), "bank_transaction");
			}
			else
			{
				$this->doBankTransaction( $child[0]['child_id'], "+");
				// set_message("<strong>Error</strong> You have deposited " . $total, 'alert-danger', $this->vars['error_vars']);
				// header('Location: /profile/deposit' . $this->vars['get']);
				// exit;
			}
		}


		$this->load->vars($this->vars);
		
		$data['addJS'] = "allocations.js";
		
		$this->load->vars($data);
		
        $this->data['pagebody']  = 'v2/deposit';
        $this->data['pagetitle'] = 'Dragon Bank | Deposit';

        $this->render();
    }
}

/* End of file deposit.php */
/* Location: ./application/controllers/deposit.php */
