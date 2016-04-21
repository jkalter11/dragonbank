<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/save_helper.php
 *
 * Useful functions to help list the appropriate menu.
 *
 * @author		RLR
 * @copyright           Copyright (c) 2011, RL ROSS
 * ------------------------------------------------------------------------
 */

function set_record($type, $post_info, $debug = false){

	$records = getRecordType($type);
	
	if( $debug )
		debug( addRecords($records, $post_info) );
        
        // Prepare an array for inserting/updating into our database.
        return addRecords($records, $post_info);

}


function save_or_update($class, $index_id, $name, $recs){

	$CI = & get_instance();
	
	if( !class_exists( $class ) )
		$CI->load->model( $class );
	
	if( isset( $recs[ $index_id ] ) && (int)$recs[ $index_id ] > 0 ) // updates
	{
	
		return $CI->$class->update($recs);
		
	}
	elseif( ! isset($recs[ $index_id ] ) && $recs != null ) // Inserts 
	{
	
		return $CI->$class->add($recs);
		
	} 
	else  // Oh... :(
	{
		debug( $recs );
		flash_redirect('signup', status('', 'Could not save or update', 'red'), 'flash' );
		return false;
		
	}
	
	return true;
}

/* End of file save_helper.php */
/* Location: /admin/application/helpers/save_helper.php */
 