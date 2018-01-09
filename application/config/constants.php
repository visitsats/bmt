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
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/* End of file constants.php */
/* Location: ./application/config/constants.php */ 


define('ASSETS_PATH','assets/');
define('IMAGE_PATH','images/');
define('ADMIN_IMAGE_PATH','images/admin/');

define('USER_SIDE_IMAGE_PATH',IMAGE_PATH.'frontend/');
define('USER_SIDE_CSS_PATH','css/frontend/'); 
define('USER_SIDE_JS_PATH','js/frontend/');
 


define('ADMIN_SIDE_IMAGE_PATH',IMAGE_PATH.'/admin/'); 
define('ADMIN_SIDE_CSS_PATH','css/admin/'); 
define('ADMIN_SIDE_JS_PATH','js/admin/'); 
 

define('DATE_FORMATE','M j,Y'); 

define("CLINT_DOMAIN_NAME","shopguard") ;

define('ASSETS_WIDTH','113');
define('ASSETS_HEIGHT','52');

define("QR_IMAGE_PATH","qrcodes") ;
define("SUPERADMIN_VERIFICATIONCODE","7891") ;


define("INDIVIDUAL_MONTHLY_PRICE",19);
define("INDIVIDUAL_ANNUAL_PRICE",180);
define("MULTIPLE_MONTHLY_PRICE",29);
define("MULTIPLE_ANNUAL_PRICE",300);
