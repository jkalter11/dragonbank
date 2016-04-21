<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/safeURL_helper.php
 *
 * Useful functions to help display stuff
 *
 * @author		RLR
 * @copyright           Copyright (c) 2013, RL ROSS
 * ------------------------------------------------------------------------
 */

function trim_url($text)
{
    // Swap out Non "Letters" with a -
    $text = preg_replace('/[^\\pL\d]+/u', '-', $text); 

    // Trim out extra -'s
    $text = trim($text, '-');

    // Convert letters that we have left to the closest ASCII representation
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // Make text lowercase
    $text = strtolower($text);

    // Strip out anything we haven't been able to convert
    $text = preg_replace('/[^-\w]+/', '', $text);

    return $text;
}

/* End of file safeURL_helper.php */
/* Location: ./application/helpers/safeURL_helper.php */