

<?php
// Create connection to Oracle

if (empty($offset) || $offset < 0) { 
    $offset=0; 
}


$dbHost = "141.238.32.126";
$dbHostPort="1521";
$dbServiceName = "xe";
$usr = "fefes";
$pswd = "password";
$dbConnStr = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
			(HOST=".$dbHost.")(PORT=".$dbHostPort."))
			(CONNECT_DATA=(SERVICE_NAME=".$dbServiceName.")))";

//limit amount of queries at one time			
//$limit = 3;			
			
$conn = oci_connect($usr, $pswd, $dbConnStr);
if (!$conn) {
   $m = oci_error();
   echo $m['message'], "\n";
   exit;
}
else {
   print "Connected to Oracle!";
}

//NOTICE: THIS HAS ALREADY BEEN RAN. WILL CAUSE A DUPLICATE.
$name = 'J';
$id = 'J1027';
$roomNo = '013';

//$sql='insert into branch(NAME, ID, ROOM) values(:name, :id, :roomNo)';
$stmt = oci_parse($conn, $sql);

oci_bind_by_name($stmt, ":name", $name);
oci_bind_by_name($stmt, ":id", $id);
oci_bind_by_name($stmt, ":roomNo", $roomNo);


if(oci_execute($stmt)) {
	echo 'success';
}

oci_free_statement($stmt);

// Close the Oracle connection
oci_close($conn);
?>