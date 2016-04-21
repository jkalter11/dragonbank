<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/display_helper.php
 *
 * Useful functions to help display stuff
 *
 * @author		RLR
 * @copyright           Copyright (c) 2013, RL ROSS
 * ------------------------------------------------------------------------
 */

/**
 * Creates an array used by function 'addRecord' that prepares records for updating/inserting into db.
 * NOTE: If you change table columns then make sure you update this function, as well.
 *
 * @param (string) $type: The type of record to create.
 * returns array.
 */
function getRecordType($type){
    switch(strtolower($type)){
        case 'user':
            $records = array('user_id'   , 'user_name' ,
                             'user_email', 'user_group',
                             'user_full_name', 'user_password', 
							 'user_phone', 'registration_date');
            break;
        case 'codes':
            $records = array('id', 'code_list_id', 'codename', 'date', 'exported', 'export_date', 'status', 'company_id', 'regional_director_id', 'advisor_id');
            break;
        case 'codeslist':
            $records = array('id', 'codelistname');
            break;
        case 'parents':
            $records = array('parent_id', 'parent_user_id', 'kids', 'active_kids', 'status', 'allowance_status', 'advisor_id');
            break;
		case 'children':
			$records = array('child_id', 'child_user_id', 'gender', 'parent_id', 'birthday', 'allowance', 'allowance_frequency', 'allowance_payday', 'balance', 'spend', 'save', 'give', 'spend_amount', 'save_amount', 'give_amount', 'profile_image', 'status', 'allocation_type', 'allowance_paydate', 'supports');
			break;
		case 'history':
			$records = array('history_id', 'history_child_id', 'transaction', 'debit', 'spend_history', 'save_history', 'give_history', 'spend_balance', 'save_balance', 'give_balance','credit', 'balance', 'desc', 'date');
			break;
		case 'settings':
			$records = array('settings_id', 'dev_email', 'pro_email', 'site_status');
			break;

		case 'companies':
			$records = array('id', 'name', 'logo', 'status');
			break;

		case 'regionaldirectors':
			$records = array('id', 'firstname', 'lastname', 'company_id', 'status', 'user_id');
			break;

		case 'advisors':
			$records = array('id', 'alias', 'position', 'address1', 'address2', 'city', 'province_id', 'postalcode', 'cell', 'fax', 'website', 'photo', 'regional_director_id', 'user_id');
			break;

        default:
            $records = array();
            break;
            
        
    }
    
    return $records;
}

/**
 * Sets an array with empty string values for each record.
 */
function setEmptyRecords( $type ){

	$temp = getRecordType( $type );
	$recs = array();
	
	foreach( $temp as $r )
		$recs[ $r ] = '';
	
	return $recs;
}

/**
 * Removes empty records from array.
 */
function removeEmptyRecords( $rec )
{
	$copy = $rec;
	foreach( $copy as $k => $v )
	{
		if( $v == "" )
		{
			unset( $rec[ $k ] );
		}
	}
	
	return $rec;
}

/**
 * Checks and adds $array data. By setting the $lvl parameter, 
 * the function will perform recursion to find and prepare the record array for db updating/inserting.
 * you must know how many levels your array contains for this to work.
 *
 * @param (array) $rec: The records to loop through.
 * @param (string) $array: The array.
 * @param (Int) $lvl: The array level.
 */
function addRecords($rec, $array, $lvl = 1){
	
	if( ! is_array( $rec ) )
		$rec = getRecordType( $rec );
	
    $records = array();

    if( $lvl <= 1 )
	{
        foreach( $rec as $r )
		{
            if( isset( $array[ $r ] ) )
			{
				if( $array[ $r ] === "" || $array[ $r ] === NULL )
				{
					$array[ $r ] = NULL;
				}
				
                $records[ $r ] = $array[ $r ];
			}
		}
    } 
	else 
	{
        foreach( $array as $next )
		{
			$records[] = $this->addRecords( $rec, $next, --$lvl );
		}
 
        return $records;
    }

    if( ! empty( $records ) )
        return $records;
        
    return null;
}


/* End of file display_helper.php */
/* Location: ./application/helpers/display_helper.php */