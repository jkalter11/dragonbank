<?php
/**
 * passwordrecovery.php Controller Class.
 */
class Passwordrecovery extends Application {

    function __construct(){
        parent::__construct();
    }
	/**
     * validates the email.
		*
     * returns true if success.
     */
    function validateForm(){
		
        $this->load->library('form_validation');
        
        $this->load->helper(array('form','validate_email'));
        
        $this->form_validation->set_rules('email', 'Email', 'required|callback_validate_the_email');
        
        if($this->form_validation->run() === FALSE)
			return false;
        else 
			return true;
    }
    
    /**
     * This is a callback function for CI's form_validation.
     * 
     * Uses the amazing php is_email script and 
     * checks to match the email set by the user with an email in the system.
		*
     * return true if all conditions met.
     */
    function validate_the_email($email){
		
        if( ! ( is_email($email) ) ){
            $this->form_validation->set_message('validate_the_email', $email.': Invalid email.');
            
            return false;
        }
        
        if( ! ( $this->usersclass->fieldExists( "user_email", $email ) ) ){
			
            $this->form_validation->set_message('validate_the_email', 'Email does not exists.');
            
            return false;
        }
		
        return true;
    }
    
    function index(){
	
        if( $_SERVER['REQUEST_METHOD'] == 'POST' )
		{
			if( ! $this->validateForm() )
			{
				flash_redirect("new/passwordrecovery", status('', validation_errors(), "red"), "flash");
			}
			
			$temp 	= random_string( 12, 3 );
			$e		= set_value('email');
			$name 	= reset(explode(" ", $this->usersclass->getNameByEmail( $e ) ) );
			
			if( sendNotification( "Dragon Bank | Password Reset", forgotPasswordMsg( $temp, $name ), $e ) )
			{
				$this->usersclass->updateWhere( array( "user_password" => md5( $temp ) ), 'user_email', $e );
				
				flash_redirect("new/passwordrecovery", status('', "Your temporary password has been sent to your email.", "green"), "flash");
			}
        }
		
        $this->data['pagebody']  = 'passwordrecovery';
        $this->data['pagetitle'] = 'Dragon Bank | Passwordrecovery ';
        $this->render();
    }
}

/* End of file passwordrecovery.php */
/* Location: ./application/controllers/passwordrecovery.php */
