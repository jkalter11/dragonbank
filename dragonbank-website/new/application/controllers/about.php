<?php
/**
 * how.php Controller Class.
 */
class About extends Application {

    function __construct(){
        parent::__construct();
    }
    /**
     * Generates a random username.
     *
     * @param (int) $length: Code length.
     * @return returns string.
     */
    private function generateUsername( $name, $length = 5 ){

        $i = 0;

        // Continues until code is unique
        while( FALSE !== ( $this->usersclass->fieldExists( "user_name", ( $user = $name.random_number( $length ) ) ) ) )
        {
            // Encase the first 10000 codes are not unique, we increase the length by 1.
            if( 100 < ++$i  )
            {
                $length++;
                $i = 0;
            }
        }

        return $user;
    }

    function index(){
        $this->data['pagebody']  	= 'v2/about';
        $this->data['pagetitle'] 	= 'About Us';
		$this->data['keys']			= 'dragon, dragonbank, children, saving, spending, giving, den, money, how';
		$this->data['desc']			= 'Dragon Bank Purchase Profile Setup Enter Access Code Create Profile Spend Save Give Record Deposits withdrawls';
		//$data["addCSS"] = "http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css";
		//$data["addJS"]	= "http://code.jquery.com/ui/1.10.3/jquery-ui.js";
		//$this->load->vars($data);

        $this->render();
    }
}

/* End of file how.php */
/* Location: ./application/controllers/how.php */