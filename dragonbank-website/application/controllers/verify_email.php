<?php
/**
 * verify_email.php Controller Class.
 */
class Verify_email extends Application {

    function __construct()
	{
        parent::__construct();
		$this->load->model("verifyemailclass");
    }
	
	function updateChimp( $email )
	{
		$this->load->helper('mailchimp');
		
		// Updates mailchimp email address for list dragon
		if( (int)$this->sud->drleid > 0 )
		{
			$drsub = array(
				'id'                => mailchimp_list_id("dragon"), // Get Dragon list id.
				'email'             => array('leid' => (int)$this->sud->drleid),
				'merge_vars'        => array('new-email', $email),
				'replace_interests' => false,
			);
			
			mailchimp_update( $drsub );
		}
		
		// Updates mailchimps email address for list partner
		if( (int)$this->sud->paleid > 0 )
		{
			$pasub = array(
				'id'                => mailchimp_list_id("partner"), // Get Dragon list id.
				'email'             => array('leid' => (int)$this->sud->paleid),
				'merge_vars'        => array('new-email', $email),
				'replace_interests' => false,
			);
			
			mailchimp_update( $pasub );
		}
		
		return;
	}
    
    function index( $key )
	{
		// Since we update the key to be 0 after success, 
		// this will prevent users from accessing this page with the value 0; 
		if( strlen($key) < 2 )
		{
			flash_redirect("new/profile/parentsprofile", status('', "Bad Key. Please try again.", "red"), 'flash_parent');
		}
		
		$email = $this->verifyemailclass->getEmail( $key );
		
		// Email was not found, show an error.
		if( ! $email )
		{
			flash_redirect("new/profile/parentsprofile", status('', "Bad Key. Could not verify email address. Please try again.", "red"), 'flash_parent');
		}
		else
		{
			// Session has expired or logged out. Login and try agin.
			if( ! isset( $this->sud->parent_id ) || $this->sud->parent_id <= 0 )
			{
				flash_redirect("login", status('', "Oops. Your session expired. Please login and click the link again.", "red"), 'flash_parent');
			}
			
			// Updates usersclass with new email.
			$this->usersclass->updateWhere( array( "user_email" => $email ), "user_id", $this->sud->user_id );
			
			// Resets the specific user's verify email row.
			$this->verifyemailclass->updateWhere( array( "email_verification_key" => 0), "email_parent_id", $this->sud->parent_id );
			
			// Sets the new email into session.
			$this->session->set_userdata("name_email", $email);
			
			// Updates mailchimps user's email address.
			$this->updateChimp( $email );

			flash_redirect("new/profile/parentsprofile", status('', "Email changed successfully", "green"), 'flash_parent');
		}
		
		exit();
    }
}

/* End of file verify_email.php */
/* Location: ./application/controllers/verify_email.php */
