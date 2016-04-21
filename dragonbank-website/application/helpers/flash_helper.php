<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/message_helper.php
 *
 * Useful functions to help list the appropriate menu.
 *
 * @author		RLR
 * @copyright           Copyright (c) 2011, RL ROSS
 * ------------------------------------------------------------------------
 */


/**
 * Either redirects or sets flashdata and redirects.
 * 
 * @param  $ret: The page to redirect to.
 * @param  $msg: The message to set in flashdata.
 * @param  $target: The key value to the flahdata array.  
 */
function flash_redirect( $ret, $msg = '', $target = 'flash' ){
	
	if( $msg != '')
	{
		$CI = & get_instance();
		$CI->session->set_flashdata($target, $msg);
	}

	redirect( $ret );
	exit();
}

/* End of file save_helper.php */
/* Location: /admin/application/helpers/save_helper.php */
 