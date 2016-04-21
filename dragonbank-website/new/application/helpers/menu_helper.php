<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/menu_helper.php
 *
 * Useful functions to help list the appropriate menu.
 *
 * @author		RLR
 * @copyright           Copyright (c) 2011, RL ROSS
 * ------------------------------------------------------------------------
 */
 
 
 /**
  * Decides which menu to display in the admin section:
  * 	1 = Main
  *		2 = Admin 
  * 
  * @param ( int ) $level: either 1, 2, or 3. 
  * @return: retuns array.
  */
function dynamicMenu( $level = 1 )
{

	// Initialize menu.
	$menu 	= array();

	$cur 	= the_url();		// Current url: http://www.a/b/c. $cur = c.
	$ret1 	= "class='active'"; // The truth return value for activePage.
	$ret2 	= "";				// The false return value for activePage.
	
	if( $level == 1)
	{
		$menu = array( 
			array( "href" => "./", "label" => "HOME", "class" => activePage($cur, "home", $ret1, $ret2) ), 
			array( "href" => "what", "label" => "WHAT IT IS", "class" => activePage($cur, "what", $ret1, $ret2) ),
			array( "href" => "how", "label" => "HOW IT WORKS", "class" => activePage($cur, "how", $ret1, $ret2) ),
			array( "href" => "order", "label" => "ORDER NOW", "class" => activePage($cur, "order", $ret1, $ret2) )
		);
	}
	else
	{
		$menu = array();
	}

	return $menu;
}

/**
* Creates a dropdown menu.
*
* @param (array) $menu: An array containing the menu data.
* @retun: returns string.
*/
function createMenu( $menu )
{
	
	$output = "<ul class='nav navbar-nav navbar-first'>";

	foreach( $menu as $m )
	{
		$output .= "<li ". $m['class'] . " >".anchor( $m['href'], $m['label'] );
		
		if( isset( $m['dropmenu'] ) && is_array( $m['dropmenu'] ) )
			addChildMenu( $m['dropmenu'], $output );
		
		$output .= "</li>";

	}

	$output .= "</ul>";

	return $output;
}

/**
* Recursive function for adding child menus.
*
* @param (array) $menu: An array containing the menu data.
* @param (string) $output: references a string.
*/ 
function addChildMenu( $menu, &$output )
{

	$output .= "<ul>";

	foreach( $menu as $m ){

		$output .= "<li>".anchor( $m['href'], $m['label'], ( isset( $m['class'] ) )? array( 'class' => $m['class'] ) : array() );
		
		if( isset( $m['dropmenu'] ) && is_array( $m['dropmenu'] ) )
			addChildMenu( $m['dropmenu'], $output );
		
		$output .= "</li>";

	}

	$output .= "</ul>";

}

/**
* Determines the current page.
* 
* @param  $cur: The current page.
* @param  $uri: The last uri segment to test.
* @param  $ret1: The TRUE return value to return.
* @param  $ret2: The False return value to return.
*
* @return  Returns anything defined in $ret1 or $ret2. 
*/
function activePage($cur, $uri, $ret1 = TRUE, $ret2 = FALSE )
{
	if( ! is_array( $uri ) )
	{
		return ( strcasecmp($cur, $uri) == 0 )? $ret1 : $ret2;
	}

	$ret = array();

	foreach($uri as $k => $v)
	{
		$ret[] = ( strcasecmp($cur, $v) == 0 )? $ret1 : $ret2;
	}

	return $ret;
}

/* End of file menu_helper.php */
/* Location: /admin/application/helpers/menu_helper.php */
 