<?php
/**
 * profile.php Controller Class.
 */
class Profile extends Application {
	
	public $var;

	function __construct(){
		parent::__construct();
		$this->load->model(array('childrenclass', 'parentsclass', 'historyclass'));
		
		$this->vars = array( "get" => "" );
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
		if( ( $ug == 2 || $ug == 3 ) && $this->sud->type_id <= 0 )
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
				flash_redirect("/new/login", status("", "You do not have permission to view that page", "red"), "login_flash");
			}
			
			$this->vars['get'] = "?child_id=$child_id";
			

			return $this->childrenclass->getChild($child_id);
		}
		
		// A child is logged in, so use session.
		return $this->childrenclass->getChild($this->sud->type_id);
	}
	
	function index()
	{
		//var_dump($this->session->userdata('typeData'));
		// Redirect parents to profile page unless a child is specified in the $_GET request.
		if($this->sud->user_group == 2 && !isset($_GET['child_id']) || (isset($_GET['child_id']) && !is_numeric($_GET['child_id'])))
		{
			redirect('new/profile/parentsprofile');
		}

		$this->vars['get'] = '';

		if ($this->session->userdata('user_group') == 2)
		{
			$this->vars['get'] = '?child_id=' . $_GET['child_id'];
			$child = $this->childrenclass->getChildByID($_GET['child_id']);
		}
		else
		{
			$child = $this->session->userdata('typeData');
		}

		if ($child == false)
		{
			redirect('new/profile/parentsprofile');
		}
		
		$this->load->vars($child);
		$this->load->vars($this->vars);
		
		$this->data['pagebody']  = 'v2/profile';
		$this->data['pagetitle'] = 'Dragon Bank | Profile ';
		$this->render();
	}
}

/* End of file profile.php */
/* Location: ./application/controllers/profile.php */
