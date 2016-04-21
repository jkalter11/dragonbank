<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/mailchimp_helper.php
 *
 * Useful function to perform mailchimp api calls
 *
 * @author		RLR
 * @copyright           Copyright (c) 2013, RL ROSS
 * ------------------------------------------------------------------------
 */

function mailchimp_list_id( $type )
{
	if( strcasecmp( $type, "dragon" ) == 0 )
	{
		return '4f5369f50b';
	}
	elseif( strcasecmp( $type, "partner" ) == 0  )
	{
		return '335e7cd11f';
	}
	
	return 0;
}

function mailchimp_list( $args = array() )
{
	$CI = & get_instance();
	
	if( ! class_exists( 'mailchimp_library' ) )
	{
		$CI->load->library('mailchimp_library');
	}
	
	$result = $CI->mailchimp_library->call('lists/list', $args );
	
	if( isset( $result['status'] ) && $result['status'] == "error" )
		return $result['error'];
	return $result['data'];
}
 
function mailchimp_subscribe( $args = array() )
{
	$CI = & get_instance();
	
	if( ! class_exists( 'mailchimp_library' ) )
	{
		$CI->load->library('mailchimp_library');
	}
	
	$result = $CI->mailchimp_library->call('lists/subscribe', $args );
	
	if( isset( $result['status'] ) && $result['status'] == "error" )
	{
		return 0;
	}

	return (int)$result['leid'];
}

function mailchimp_unsubscribe( $args = array() )
{
	$CI = & get_instance();
	
	if( ! class_exists( 'mailchimp_library' ) )
	{
		$CI->load->library('mailchimp_library');
	}
	
	$result = $CI->mailchimp_library->call('lists/unsubscribe', $args );
	
	if( isset( $result['status'] ) && $result['status'] == "error" )
	{
		return 0;
	}

	return $result['complete'];
}

function mailchimp_update( $args = array() )
{
	$CI = & get_instance();
	
	if( ! class_exists( 'mailchimp_library' ) )
	{
		$CI->load->library('mailchimp_library');
	}
	
	$result = $CI->mailchimp_library->call('lists/update-member', $args );
	
	if( isset( $result['status'] ) && $result['status'] == "error" )
	{
		return 0;
	}
	
	return (int)$result['leid'];
}
 
/* End of file mailchimp_helper.php */
/* Location: ./application/helpers/mailchimp_helper.php */