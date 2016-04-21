<?php

if (!defined('APPPATH'))
    exit('No direct script access allowed');

/**
 * helpers/encrypt_helper.php
 *
 * Useful functions to help encrypt stuff
 *
 * @author		RLR
 * @copyright           Copyright (c) 2011, RL ROSS
 * ------------------------------------------------------------------------
 */
 
 /**
  * Generates a random salt.
  */
 function rand_salt_generator($algo = 'ripemd160', $min = 100000000, $max = 1000000000){
     return hash($algo, base64_encode( bin2hex(mt_rand($min, $max) ) ) );
 }
 
 /**
  * Encrypts user password.
  *
  * @param (string) $str: The user entered password.
  * @param (string) $salt: The salt to add to password.
  */
 function crypt_password($str, $salt){
     return hash('tiger192,4', $str.$salt);
 }
 
 
/* End of file encrypt_helper.php */
/* Location: ./application/helpers/encrypt_helper.php */