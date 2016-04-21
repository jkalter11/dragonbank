<?php

class Code_test extends Application
{

	function __construct()
	{
		parent::__construct();

	}

	function index()
	{


		// get active advisors
		$query = $this->db->query('
			SELECT id, user_full_name
			FROM advisors
			INNER JOIN users
			ON users.user_id = advisors.user_id
			WHERE users.status = 1
			ORDER BY id
		');

		echo $query->num_rows();
		echo "<br>-----<br>";
		// for each advisor
		foreach ($query->result() as $a)
		{
			$used = 0;
			$codesToAssign = array();

			echo $a->user_full_name . " | id: " . $a->id . "<br>";

			$query2 = $this->db->query('
				SELECT *
				FROM codes
				WHERE advisor_id = ?
			', array($a->id));

			foreach ($query2->result() as $c)
			{
				if ($c->status == 0)
				{
					++$used;
					$codesToAssign[] = $c;
				}
			}

			echo "Number of codes: " . $query2->num_rows() . " | Used: " . $used . "<br>";

			$query2 = $this->db->query('
				SELECT *, uc.user_full_name, code_id
				FROM children 
				INNER JOIN parents 
				ON children.parent_id = parents.parent_id
				INNER JOIN users uc
				ON children.child_user_id = uc.user_id
				WHERE parents.advisor_id = ? 
				AND children.status = 1'
			, array($a->id));

			echo "Number of children: " . $query2->num_rows();

			if ($used != $query2->num_rows())
			{
				echo "<br><strong>MISMATCH IN CHILD/CODE USAGE</strong>";
			}


			echo "<br>Assignment:<br>";
			$i = 0;

			foreach ($query2->result() as $child)
			{
				echo $child->user_full_name . ' : ' . $codesToAssign[$i]->codename . ' (got ' . $child->code_id . ', gets: ' . $codesToAssign[$i++]->id . ')' . '<br>';
				//$data = array('code_id' => $codesToAssign[$i++]->id);
				//$this->db->where('child_id', $child->child_id);
				//$this->db->update('children', $data);

				//echo $child->user_full_name . ' : ' . $codesToAssign[$i]->codename . ' (' . $codesToAssign[$i++]->id . ')' . '<br>';
			}
			

			echo "<br>--------------------------------------<br>";
		}

		
			// get codes
			// get children

			// compare used codes to children




		// $query = $this->db->query('SELECT * FROM codes WHERE codes.status = 0');
		// echo $query->num_rows();

		// echo "<br>-----<br>";
		

		// $query = $this->db->query('
		// 	SELECT user_full_name, children.status cStatus, users.status uStatus 
		// 	FROM children 
		// 	INNER JOIN users 
		// 	ON children.child_user_id = users.user_id
		// 	WHERE users.status = 1
		// ');
		// echo $query->num_rows();
	}

}