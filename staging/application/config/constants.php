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
//fb
define('APP_ID', '1418004945077691');
define('APP_SECRET','75a9a8e052557cd5e26de37946da12f6');
define('FB_PAGE','172858489550728');
//fb

//doku
define('MALLID', '669');
define('SHARED_KEY', '01zgZ5SEPd2i');
//define('DOKU_URL','http://103.10.129.17/Suite/Receive');//testing server
define('DOKU_URL','https://pay.doku.com/Suite/Receive'); //production server
define('BASEURL','http://'.$_SERVER['HTTP_HOST'].'/toriokids/');
//doku

//isys loophole
define('DOMAIN_ID','2');
//isys loophole

//stamps
define('STAMPS_TOKEN','931f92e41b8f368783c27fcb4dc5f1d7579c1281');
define('STAMPS_STORE','278');
define('STAMPS_MERCHANT','94241');
define('FANSPAGE_ID','172858489550728');
//stamps

/* End of file constants.php */
/* Location: ./application/config/constants.php */