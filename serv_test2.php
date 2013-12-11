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

$sql = "Select count(*) from branch";
$stmt = oci_parse($conn, $sql);
oci_execute($stmt);



$total_rows = oci_fetch_array($stmt);
    
if ( !$total_rows[0] ) {
    echo "<h1>Error - no rows returned!</h1>";
    exit;
}

echo "<br>There are <b>$total_rows[0]</b> results. <br> <br>\n"; 
//echo "Now showing results <b>$begin</b> to <b>$end</b>.<br><br>\n";     

oci_free_statement($stmt);

$sql = "Select * from branch";
    
$stmt = oci_parse($conn, $sql);

if(!$stmt) {
    echo "<h1>ERROR - Could not parse SQL statement.</h1>";
    exit;
}


 // The defines MUST be done before executing
oci_define_by_name($stmt, 'NAME', $br_name);
oci_define_by_name($stmt, 'ID', $br_id);
oci_define_by_name($stmt, 'ROOM', $br_room);

oci_execute($stmt);

// Each fetch populates the previously defined variables with the next row's data
while (oci_fetch($stmt)) {
    echo "Name: $br_name with id $br_id is in room $br_room <br>\n";
}


oci_free_statement($stmt);

// Close the Oracle connection
oci_close($conn);
?>