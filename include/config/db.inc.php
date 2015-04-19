<?php
/**
* /include/config/ 밑에 둘 것
*
*/
//require_once($config['basedir'] . '/libraries/adodb/adodb.inc.php');
include('path.inc.php');
require_once($config['basedir'] . '/libraries/adodb/adodb.inc.php');
$DBTYPE = 'mysql';
$DBHOST = '127.0.0.1';

$DBUSER = 'root';
$DBPASSWORD = 'ttitick2015';
$DBNAME = 'ttitick_ts';

$conn = &ADONewConnection($DBTYPE);
$conn->PConnect($DBHOST, $DBUSER, $DBPASSWORD, $DBNAME);
@mysql_query("SET NAMES 'UTF8'");


?>
