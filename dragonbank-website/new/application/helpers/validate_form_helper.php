<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/validate_form_helper.php
 *
 * Useful functions to help list the appropriate menu.
 *
 * @author		RLR
 * @copyright           Copyright (c) 2011, RL ROSS
 * ------------------------------------------------------------------------
 */
 
 /**
  * Validates form using array parameters. Redirects if false, otherwise continues. 
  * Example:
  *
  * $fields = array( name => Name, email => User email )
  *
  * @param (array) $fields: array of field names.
  * @param (string) $ret: Where to redirect on form invalidation.
  */
 function validateForm( $fields = array(), $ret = '/', $run = TRUE){
 	
 	$CI = & get_instance();
 	
 	if( empty( $fields ) )
 		return;
  
	$CI->load->library('form_validation');   
	
	// Sets the form rules.
	foreach( $fields as $k => $v )
	{
		if( ! is_array( $v ) )
		{
			$CI->form_validation->set_rules($k, $v,  'required');
			continue;
		}
		
		$rules 	= 0;
		$msg	= $v['msg'];
		
		foreach( $v as $f => $n )
		{
			if( $rules === 0 )
			{
				$rules = "$n";  
			}
			else
			{
				$rules .= "|$n";
			}
		}
		
		$CI->form_validation->set_rules($k, $msg, $rules);
	}
	
	if( $run === TRUE && ! $CI->form_validation->run())
	{

		$CI->session->set_flashdata('flash', validation_errors("<span class='red'>", "<br /></span>") );

		redirect($ret);
		exit();
	}
	
	return;
}


/* End of file validate_form_helper.php */
/* Location: /admin/application/helpers/validate_form_helper.php */
 