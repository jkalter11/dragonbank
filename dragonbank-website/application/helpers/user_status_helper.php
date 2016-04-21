<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/user_status_helper.php
 *
 * Useful functions to help display stuff
 *
 * @author		RLR
 * @copyright           Copyright (c) 2013, RL ROSS
 * ------------------------------------------------------------------------
 */
    
    /**
     * Checks if user is logged in.
     */
    function isLoggedIn(){
    	
    	$CI = & get_instance();
    	
    	$user = $CI->session->userdata('user_group');
    		
    	// Guests are set as a zero value and therefore cannot be logged in.
    	if( ! $user )
    		return false;
    	
    	// We have already chacked for zero, so go ahead and check for users that are greater than the allowed group levels.
    	if( ! $CI->session->userdata('logged_in') || ! $CI->session->userdata('initiated') )
    		 return false;
    	
    	return true;
    }
    
    /**
     * Checks group permessions.
     *
     * @param (string) $group: the user group name to check for. 
     */
    function isAdmin(){
    	
    	$CI = & get_instance();
    	
    	$user = $CI->session->userdata('user_group');
    	
    	// If user is not zero AND the user level is higher than or equal too groups level, 
    	// but in this case higher level means lower numbers.
    	return ( 1 == $user );
    }
    
    /**
     * Checks group permessions.
     *
     * @param (string) $group: the user group name to check for. 
     */
    function isAllowed( $group = 0 ){
    	
    	$CI = & get_instance();
    	
    	$user = $CI->session->userdata('user_group');
    	
    	// If user is not zero AND the user level is higher than or equal too groups level, 
    	// but in this case higher level means lower numbers.
    	return ( $user && $user <= $group );
    }
    
    function isUser( $email = '' ){
    	$CI = & get_instance();
    	
    	if( ! class_exists( 'usersclass' ) )
    		$CI->load->model('usersclass');
    	
    	if( '' === $email )
    		return $CI->session->userdata('user_id');
    	else
    		return $CI->usersclass->fieldExists( $email );
    }
	
	/**
	 * Checks if parent is the actually the childs parent.
	 */
	function isParent( $cid )
	{
		$cid = (int)$cid;
		
		$CI = & get_instance();
		
		if( $cid <= 0 || $CI->sud->user_group != 2 )
		{
			return FALSE;
		}
		
		if( ! class_exists('childrenclass') )
			$CI->load->model('childrenclass');
		
		return ( $CI->childrenclass->fieldExists("child_id", $cid) && 
				(int)$CI->sud->type_id == (int)$CI->childrenclass->getParentId( $cid ) );
	}
	
	function isMaintenance()
	{
		$CI = & get_instance();
		
		if( ! class_exists("settingsclass") )
		{
			$CI->load->model("settingsclass");
		}
		
		return ( (int)$CI->settingsclass->getStatus() === 0 );
	}
	
	function isActive()
	{
		$CI = & get_instance();
		
		if( ! class_exists("usersclass") )
		{
			$CI->load->model("usersclass");
		}
		
		$s = (int)$CI->usersclass->getStatus( $CI->sud->user_id );
		
		return ( $s === 1 );
	}
	