<?php
/**
 * export_history.php controller class.
 */
class Export_history extends Application {
    function __construct(){
        parent::__construct();
        $this->load->model( array('history') );
    }
    
    /** 
     * Sets the display for the amount of the discount code to show either a percent or dollar sign.
     *
     * @param (array) $data: Using a reference to store array data.
     */
    private function createCSV( $history ){

    	// send response headers to the browser
		header( 'Content-Type: text/csv' );
		header( 'Content-Disposition: attachment;filename=codes_'.date("Y_m_d").'_list.csv');

		$fp = fopen('php://output', 'w');

		fputcsv($fp, array('Name', 'Date', 'export_date'));
		fputcsv($fp, array('',''));

		$export_date = date("Y-m-d");
		
		$data = array( "id" => 0, "export_date" => $export_date, "exported" => 1 );
		
        foreach( $codes as $k => $row ){
        
        	if( ! $row ){
        		echo 'row failed';
        		exit();
        	}
			
			$data['id'] = $row['id'];
			
			$this->codesclass->update($data);
        	
        	fputcsv( $fp, array( $row['codename'], $row['date'], $export_date ) );
        }
       
        fclose($fp);
        
        // We need to prevent any more output from being sent to the browser.
        exit();
    }
    
    function index(){
    	
    	if( $this->reqType( 'GET' ) )
		{
			$s = 0;
			$e = 0;
			$l = 0;
			
			if( isset( $_GET['start'] ) && $_GET['start'] !== "" )
			{
				$s = str_replace("'", "", $_GET['start']);
			}
			
			if( isset( $_GET['end'] ) && $_GET['end'] !== "")
			{
				$e = str_replace("'", "", $_GET['end']);
			}
			
			if( isset( $_GET['list_id'] ) && (int)$_GET['list_id'] > 0 )
			{
				$l = (int)$_GET['list_id'];
			}

			$this->createOrderCSV( $s, $e, $l );
		}
    	
    	exit();
    }
}

/* End of file export_history.php */
/* Location: ./application/controllers/export_history.php */