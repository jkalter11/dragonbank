<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * code.php Controller Class.
 */
class Code extends Application {

    function __construct(){
        parent::__construct();
		
		$this->load->model( array("codeslistclass", "codesclass") );
    }
    
    /**
     * Generates a random access code.
	 *
     * @param (int) $length: Code length.
     * @return returns string.
     */
    private function generateCode( $length = 8 ){
    	
    	$i = 0;
    	
		// Continues until code is unique
    	while( FALSE == ( $this->codesclass->uniqueCode( $code = random_string( $length, 3 ) ) ) )
		{ 
    		// Encase the first 10000 codes are not unique, we increase the length by 1.
    		if( 100 < ++$i  )
			{
    			$length++;
    			$i = 0;
    		}
    	}
    	
    	return $code;
    }
	
	function saveCodeList()
	{
		// The records to save to codelist table.
		$rec = ( count($_POST) == 1 )? $_POST : array( "codelistname" => $_POST['codelistname'] );

		save_or_update( 'codeslistclass', 'id', 'Code List', $rec );
	}
	
	function saveCodes( $amount, $list, $limit = 50000, $companyID = 0, $directorID = 0, $advisorID = 0 )
	{
		
		$i = 0;
		
		$rec = array( 
			"codename" 		=> "",
			"date" 			=>	date("Y-m-d"),
			"code_list_id" 	=> ( (int)$this->codeslistclass->getIdByName( $list ) ),
			"company_id" => (($companyID == 0) ? NULL : $companyID),
			"regional_director_id" => (($directorID == 0) ? NULL : $directorID),
			"advisor_id" => (($advisorID == 0) ? NULL : $advisorID)
		);


		
		while( $amount > 0 )
		{
			$records = array();
			
			if( $amount < $limit )
			{
				$limit = $amount;
			}
			
			$c = $this->getUniqueRecords( $limit );
			
			$num_gen = (int)count( $c );
			
			foreach( $c as $k => $v )
			{
				$rec['codename']	= $v;
				$records[] 			= $rec;
			}
			
			$amount -= $num_gen;
			
			$this->codesclass->batch_add($records);
		}
	}
	
	private function getUniqueRecords( $limit )
	{
		$c = array();
		
		for($i = 0; $i < $limit; $i++)
		{
			$code = $this->generateCode();
			
			$c[ $code ] = $code;
		}
		
		return $c;
	}
    
    function index(){
		if( $this->reqType("POST") && isset( $_POST['codelistname'] ) )
		{
			//$this->saveCodeList();
		}
		elseif( $this->reqType("POST") && isset( $_POST['amount'] ) && isset( $_POST['entity'] ) )
		{

			$this->saveCodes( (int)$_POST['amount'], $_POST['entity'], 50000, $_POST['company'] , $_POST['regionaldirector'], $_POST['advisor']);
		}

		

        $this->data['pagebody']  = 'code';
        $this->data['pagetitle'] = 'Dragon Bank | Code ';
		
		$data['addJS'] = "jquery.validate.min.js, validateForm.js";
		
		$data['codelist'] = $this->codeslistclass->getAllLists();


		$this->load->model(array('companiesclass', 'regionaldirectorsclass', 'advisorsclass'));

		$companies = $this->companiesclass->getActiveCompanies();

		$data['companies'] = $companies;

		
		// Extracts the array into variables.
		$this->load->vars( $data );

        $this->render("_template_admin");
    }
}

/* End of file code.php */
/* Location: ./application/controllers/code.php */