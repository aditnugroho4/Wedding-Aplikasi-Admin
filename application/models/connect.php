<?php
error_reporting(E_ALL ^ E_DEPRECATED); 
try{
ini_set('display_errors',0);	
ini_set('memory_limit' , '128M');
$hostname = '10.14.2.24';
$database = 'newsimrs';
$username = 'simrs';
$password = '375607';
$connect = mysql_connect($hostname, $username, $password,true,65536);
if ($connect){
	 mysql_select_db($database,$connect);
	 }else{
	//echo ('error');
		}
}catch (Exception $e) 
{
  $e->getMessage();
}
?>