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
 * Retrieve the contents of a file and prepare it for browser display.
 *
 * Example usage (inside a controller method):
 *  $this->load->helper('display');
 *  $data['contents'] = display_file('./data/flights.dtd');
 *  $this->load->view('whatever',$data);
 *
 * @param string $filename  Name of the file whose contents you want to display, relative to the document root
 * @return string   The appropriately encoded text string containing that file's contents.
 */
function display_file($filename) {
    $CI = & get_instance();      // get "our" object instance reference, because this is just a function
    $CI->load->helper('file');  // load the CI file helper
    $stuff = read_file($filename);    // retrieve the requested file content
    $stuff = htmlentities($stuff);  // convert any HTML entities
    $stuff = '<code><pre>' . $stuff . '</pre></code>';  // bracket the result inside *code* and *pre* HTML elements

    return $stuff;  // whew!
}

/**
 * Sets the status message.
 *
 * @param (string) $s: The message type.
 * @param (string) $t: The page type. Example(page, gallery, user, etc).
 * returns string containing html code.
 */
function status($s, $t = '', $c = "red"){	
    switch($s){
		case 'added':
			return '<div class="message green"><span><strong>Added '.$t.' successfully</strong></span></div>';
			break;

		case 'deleted':
			return '<div class="message green"><span><strong>Deleted '.$t.' successfully</strong></span></div>';
			break;

		case 'updated':
			return '<div class="message green"><span><strong>Updated '.$t.' successfully</strong></span></div>';
			break;

		case 'denied':
			return '<div class="message red"><span><strong>Error: You do not have permission to edit this '.$t.'!</strong></span></div>';
			break;
		case 'error':
			return '<div class="message red"><span><strong>An error has occurred! '.$t.'</strong></span></div>';
			break;
		case 'super':
			return '<div class="message red"><span><strong>Admin super user cannot be deleted.</strong></span></div>';
			break;
		case 'loginFail':
			return  '<div class="message red"><span><strong>Invalid user name or password. Please try again.</strong></span></div>';
			break;  
		case 'match':
			return  '<div class="message red"><span><strong>Passwords must match. Please try again.</strong></span></div>';
			break;
		case 'shortPass':
			return  '<div class="message red"><span><strong>Your password must be at least 5 characters long.</strong></span></div>';
			break;  
		case 'fields':
			return  '<div class="message red"><span><strong>Please fill in all fields.</strong></span></div>';
			break;
		case 'email':
			return  '<div class="message red"><span><strong>Please enter a valid email.</strong></span></div>';
			break;
		case 'shortUser':
			return  '<div class="message red"><span><strong>Your Username must be at least 2 characters long.</strong></span></div>';
			break;
		default:
			return "<div class='message $c'><span><strong>$t</strong></span></div>";
			break;
    }
}

/**
 * Debug anything easily. This will save you a lot of time.
 *
 * @param (anything) $obj: The anything to debug.
 * @param (boolean) $die: Whether or not to use die().
 */
function debug($obj, $die = true){

	echo "<pre>";
    print_r($obj);
	echo "</pre>";
    if($die)
        die();
}

/**
 * Random alpha-numeric.
 *
 * @param  (int) $length: string length.
 * @param  (int) $seperator: The seperator amount to add numbers between characters. 
 * 							Make it same as length to have only numbers 
 * @retuen string.
 */
function random_string( $length, $seperator = 1 ) {
	
	$key 	= '';
	$key1 	= "abcdefghijkmnpqrstuvwxyzABCDEFGHIJKLMNPQRSTUVWXYZ";
	$key2	= "23456789";
	$max1 	= strlen($key1) - 1;
	$max2 	= strlen($key2) - 1;
	
	// Initialize $key with the first letter.
	$key .= $key1[ ( mt_rand(0, $max1 ) ) ];
	
	// We have to start at 1 since we already added 1 letter.
	for ($i = 1; $i < $length; $i++)
	{
		if( $i % $seperator == 0 )	// Adds a number.
		{
			$key .= $key2[ ( mt_rand(0, $max2 ) ) ];
		}
		else 						// Adds a letter.
		{
			$key .= $key1[ ( mt_rand(0, $max1 ) ) ];
		}
	}
	
	return $key;
}

/**
 * Random number.
 *
 * @param  (int) $length: string length.
 * @retuen string.
 */
function random_number( $length ) {
	
	$key 	= '';
	$key1	= "0123456789";
	$max1 	= strlen($key1) - 1;
	
	// We have to start at 1 since we already added 1 letter.
	for ($i = 0; $i < $length; $i++)
	{
		$key .= $key1[ ( mt_rand(0, $max1 ) ) ];
	}
	
	return $key;
}


/* End of file display_helper.php */
/* Location: ./application/helpers/display_helper.php */