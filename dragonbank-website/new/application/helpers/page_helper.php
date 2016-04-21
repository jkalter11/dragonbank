<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/page_helper.php
 *
 * Useful functions to help display stuff
 *
 * @author		RLR
 * @copyright           Copyright (c) 2013, RL ROSS
 * ------------------------------------------------------------------------
 */

    function the_url(){

		$_CI =& get_instance();

		$t = $_CI->uri->total_segments();

		if( $t > 2 )
		{
			$cur_uri = $_CI->uri->segment( $t - ($t - 2) );
		}
		else
		{
			$cur_uri = $_CI->uri->segment( $t );
		}

		// Finds the last url segment, which should be the page to view.
		if( $cur_uri )
		{
			return $cur_uri;
		}
	    
	    // uri->segments cannot find home page, so we help it.
	    if( current_url() == site_url() && isset( $_CI->homepage ) )
	        return $_CI->homepage;
	    
	    return false;
    }
	
	function the_folder(){
		
		$_CI =& get_instance();

		$seg = $_CI->uri->segment(1);

		/*
		// Finds the folder name.
		if (($cur_area = $_CI->uri->segment(($_CI->uri->total_segments() - 1 ))))
			return $cur_area;
		*/

		if (empty($seg))
		{
			// uri->segments cannot find home page, so we help it.
			if( current_url() == site_url() && isset( $_CI->homepage ) )
				return "main";
				
			return false;
		}

		return $seg;
		
	}

    /**
     * Builds page's html structure.
     *
     * @param: $url the url.
     * @param: $name the page's name.
     * @param: $f string reference
     * @param: $class the top level li class.
     *
     * @return: Returns string of html code.
     */
     function insertHtml($url, $name, &$f, $class = ''){
        
        if( '' === $class )
        	$f .= "<li>".anchor( $url, $name );
        else
        	$f .= "<li class='".$class."'>".anchor( $url, $name );                   
     }
    
    /**
     * Generates random token.
     */
    function token_generator(){
        return hash('ripemd160', base64_encode( bin2hex(mt_rand(100000000, 1000000000) ) ) );
    }
    
    /**
     * Protect against CSRF attacks
     * return true if there IS a security risk.
     */
     function CSRF_security_risk($token){
         $_CI =& get_instance();
         
         return ( $_CI->session->userdata('token') !== $token );
     }

/* End of file page_helper.php */
/* Location: ./application/helpers/page_helper.php */