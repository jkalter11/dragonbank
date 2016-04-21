<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/head_helper.php
 *
 * Useful functions to help display stuff
 *
 * @author		RLR
 * @copyright           Copyright (c) 2013, RL ROSS
 * ------------------------------------------------------------------------
 */
       
    /**
     * Add css stylesheets
     *
     * @param: array of stylesheets href to add.
     */
	function add_css($add = null)
	{
		if( is_array( $add ) )
		{
			foreach( $add as $k => $v )
			{
				$v = trim($v);
				
				echo( strlen( reset( explode("http",$v) ) ) === 0 )		?
				"<link rel='stylesheet' href='$v'>"						:
				"<link rel='stylesheet' href='".CSS_PATH."$v'>"			;
			}
		}
		else
		{
			$array = explode( ",", $add );
			
			if( count($array) == 1 )
			{
				$add = trim($add);
				echo( strlen( reset( explode("http",$add) ) ) === 0 )	?
				"<link rel='stylesheet' href='$add'>"					:
				"<link rel='stylesheet' href='".CSS_PATH."$add'>"		;
			}
			else
			{
				foreach( $array as $k => $v )
				{	
					$v = trim($v);
					echo( strlen( reset( explode("http",$v) ) ) === 0 )	?
					"<link rel='stylesheet' href='$v'>"					:
					"<link rel='stylesheet' href='".CSS_PATH."$v'>"		;
				}
			}
		}
	}
    /**
    * Add js scripts
    *
    * @param: string src the javascript to add. Add all if null.
    */
    function add_js($add = null)
	{
		if( is_array( $add ) )
		{
			foreach( $add as $k => $v )
			{
				$v = trim($v);
				
				echo( strlen( reset( explode("http",$v) ) ) === 0 )		?
				"<script src='$v'></script>"							:
				"<script src='".JS_PATH."$v'></script>"					;
			}
		}
		else
		{
			$array = explode( ",", $add );
			
			if( count($array) == 1 )
			{
				$add = trim($add);
				echo( strlen( reset( explode("http",$add) ) ) === 0 )		?
				"<script src='$add'></script>"							:
				"<script src='".JS_PATH."$add'></script>"					;
			}
			else
			{
				foreach( $array as $k => $v )
				{
					$v = trim($v);
					echo( strlen( reset( explode("http",$v) ) ) === 0 )		?
					"<script src='$v'></script>"							:
					"<script src='".JS_PATH."$v'></script>"					;
				}
			}
		}
    }

/* End of file head_helper.php */
/* Location: ./application/helpers/head_helper.php */ 