<?php


$active_group = 'default';
$query_builder = TRUE;

$dbset[0]['hostname'] = '52.21.205.142';
$dbset[0]['user'] = 'devel1';
$dbset[0]['password'] = 'devel001';
$dbset[1]['hostname'] = '52.21.205.142'; //'54.209.1.149';
$dbset[1]['user'] = 'webuser';
$dbset[1]['password'] = 'WebUserPass1';
$wichdb = 0;

if ($_SERVER["HTTP_HOST"] == 'localhost') {
  $wichdb = 0;
} else {
  $wichdb = 1;
}

$db['default'] = array(
	'dsn'	=> '',
	'hostname' => $dbset[$wichdb]['hostname'],
	'username' => $dbset[$wichdb]['user'],   // webuser
	'password' => $dbset[$wichdb]['password'],  // WebUserPass1
	'database' => 'onecloud_omp',
	'dbdriver' => 'mysqli',
	'dbprefix' => '',
	'pconnect' => FALSE,
	'db_debug' => (ENVIRONMENT !== 'production'),
	'cache_on' => FALSE,
	'cachedir' => '',
	'char_set' => 'utf8',
	'dbcollat' => 'utf8_general_ci',
	'swap_pre' => '',
	'encrypt' => FALSE,
	'compress' => FALSE,
	'stricton' => FALSE,
	'failover' => array(),
	'save_queries' => TRUE
);
