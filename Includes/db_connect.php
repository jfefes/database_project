<?php
$dbHost = "141.238.32.126";
$dbHostPort="1521";
$dbServiceName = "xe";
$usr = "andrew";
$pswd = "password";
$dbConnStr = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
			(HOST=".$dbHost.")(PORT=".$dbHostPort."))
			(CONNECT_DATA=(SERVICE_NAME=".$dbServiceName.")))";
		
			
if(!$conn = oci_connect($usr,$pswd,$dbConnStr)){
	$err = oci_error();
	trigger_error('Could not establish a connection to Oracle');
}

?>