<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb');  // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


switch( $_SERVER['HTTP_HOST'] )
{
    case "dev11.604media.com":
    case "www.dev11.604media.com":
        define('BASE_URL', 'http://dev11.604media.com/dragonbank/');
        break;
    case "dev.dragonbank.com":
    case "www.dev.dragonbank.com":
		define('BASE_URL', 'http://dev.dragonbank.com/');
		break;
    case "dragonbank.com":
    case "www.dragonbank.com":
        define('BASE_URL', 'http://dragonbank.com/');
        break;
    default:
        define('BASE_URL', 'http://dragonbank.com/');
        break;
}

define('CSS_PATH', 		BASE_URL . 'assets/css/');
define('JS_PATH', 		BASE_URL . 'assets/js/');
define('ASS_PATH', 		BASE_URL . 'assets/');
define('ASS_IMG_PATH', 	BASE_URL . 'assets/images/');
define('ASS_PROFILE_PATH',BASE_URL . 'assets/images/profiles/');
define('IMG_PATH', 		BASE_URL . 'data/images/');
define('FILES_PATH',	BASE_URL . 'data/files/');
define('PROFILE_PATH',	BASE_URL . 'data/images/profiles/');
define('ADV_PROFILE_PATH',  BASE_URL . 'data/profile/advisors/');
define('ACH_IMG_PATH', BASE_URL . 'data/achievements/');
define('COMPANY_PROFILE_PATH',  BASE_URL . 'data/profile/companies/');
define('ROOT_FILE_PATH',dirname(dirname(dirname(__FILE__) ) ) ); // Three level needed to get to the starting folder.

// Email From
define('EMAIL_FROM', 'support@enrichedacademy.com');

/* End of file constants.php */
/* Location: ./application/config/constants.php */