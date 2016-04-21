<?php

	class Wishlist extends Application {

	function __construct(){
		parent::__construct();
		$this->load->model(array('wishlistclass', 'childrenclass'));
	}



	function export()
	{

		$child = $this->childrenclass->getChild($_GET['child_id']);
		$wishlist = $this->wishlistclass->getWishlistByChildID($_GET['child_id']);


		// send response headers to the browser
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename=' . str_replace(' ', '_',  $child[0]['user_full_name']) . '_'.date("Y_m_d").'_wishlist.csv');
		
		$fp = fopen('php://output', 'w');
		
		fputcsv($fp, array('Date', 'Item', 'Cost', '% of Money to Goal'));
		fputcsv($fp, array('', '', '', ''));
		
		foreach($wishlist as $row)
		{
			$percent = (int)($child[0]['spend_amount'] / $row->cost * 100);
			if ($percent > 100)
			{
				$percent = 100;
			}
			fputcsv($fp, array(date('Y-m-d', $row->date), $row->item, '$' . $row->cost, $percent . '%'));
		}
		exit;
	}
	
	function index()
	{

		// Redirect parents to profile page unless a child is specified in the $_GET request.
		if($this->sud->user_group == 2 && !isset($_GET['child_id']) || (isset($_GET['child_id']) && !is_numeric($_GET['child_id'])))
		{
			redirect('new/profile/parentsprofile');
		}

		$this->vars['get'] = '';

		if ($this->session->userdata('user_group') == 2)
		{
			$this->vars['get'] = '?child_id=' . $_GET['child_id'];
			$child = (array)$this->childrenclass->getChildByID($_GET['child_id']);
		}
		else
		{
			$child = $this->session->userdata('typeData');
		}

		if ($child == false)
		{
			redirect('new/profile/parentsprofile');
		}
		
		$this->vars['wishlist'] = (array)$this->wishlistclass->getWishlistByChildID($child['child_id']);

		$this->vars['item'] = '';
		$this->vars['cost'] = '';

		if (isset($_POST['deletewishlistitem']))
		{
			$this->vars['deleteid'] = $_POST['wid'];
		}

		if (isset($_POST['deletewishlist']))
		{
			if ($_POST['deletewishlist'] == 'YES')
			{
				$this->db->delete('wishlist', array('id' => $_POST['wishlistid']));
				set_message("<strong>Success</strong> Item has been deleted", 'alert-success');
			}
			header('Location: /new/profile/wishlist' . $this->vars['get']);
			exit;
		}

		if (isset($_POST['add_wishlist']))
		{
			$errors = array();
			$this->vars['item'] = trim($_POST['item']);
			if (strlen($this->vars['item']) == 0)
			{
				$errors['item'] = 'Item cannot be blank';
			}
			else if (strlen($this->vars['item']) > 64)
			{
				$errors['item'] = 'Item cannot be greater than 64 characters';
			}

			$this->vars['cost'] = trim($_POST['cost']);
			if (strlen($this->vars['cost']) == 0)
			{
				$errors['cost'] = 'Cost cannot be blank';
			}
			else if (!is_numeric($this->vars['cost']))
			{
				$errors['cost'] = 'Cost must be a number';
			}
			else if ($this->vars['cost'] <= 0)
			{
				$errors['cost'] = 'Cost cannot be a negative value or 0';
			}


			if (count($errors))
			{
				$this->vars['error_vars'] = $errors;
				set_message("<strong>Error</strong> There is a problem with your submission", 'alert-danger', $errors);
			}
			else
			{
				$data = array(
					'child_id' => $child['child_id'],
					'item' => $this->vars['item'],
					'cost' => $this->vars['cost'],
					'date' => time()
				);

				setWishlistAchievement($child['child_id']);

				$this->db->insert('wishlist', $data);
				set_message("<strong>Success</strong> Item has been added", 'alert-success');

				header('Location: /new/profile/wishlist' . $this->vars['get']);
				exit;
			}

		}


		$this->data['pagebody']  	= 'v2/wishlist';
		$this->data['pagetitle'] 	= 'Wishlist';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Dragon Bank Purchase Profile Setup Enter Access Code Create Profile Spend Save Give Record Deposits withdrawls';
		//$data["addCSS"] = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		//$data["addJS"]	= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		$this->load->vars($child);
		$this->load->vars($this->vars);
		$this->render();
	}
}
