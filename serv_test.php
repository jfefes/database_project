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
$limit = 3;			
			
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

$begin =($offset+1); 
$end = ($begin+($limit-1)); 
if ($end > $total_rows[0]) { 
    $end = $total_rows[0]; 
}

echo "<br>There are <b>$total_rows[0]</b> results.<br>\n"; 
echo "Now showing results <b>$begin</b> to <b>$end</b>.<br><br>\n";     

oci_free_statement($stmt);

$sql = "Select * from branch";
    
$stmt = oci_parse($conn, $sql);

if(!$stmt) {
    echo "<h1>ERROR - Could not parse SQL statement.</h1>";
    exit;
}

oci_execute($stmt);

$i=0;
$j=0;

while($result_array= oci_fetch_array($stmt)){
    if ($i>=$offset) {
        if ($j <$limit) {
            for ($k=0; $k<=count($total_rows); $k++) {
                echo $result_array[$k]." ";
            }
            echo "<br/>";
            $j++;
        }
    }
    $i++;
}
echo "
";

/*
The results have been displayed for the current page.  Time to give the 
visitor a way to hit the other pages!  On with the NEXT/PREV links!
*/

// Calculate total number of pages in result 
$pages = intval($total_rows[0]/$limit); 
     
// $pages now contains total number of pages needed 
// unless there is a remainder from division  
if ($total_rows[0]%$limit) { 
    // has remainder so add one page  
    $pages++; 
} 

// Don't display PREV link if on first page 
if ($offset!=0) {   
    $prevoffset=$offset-$limit; 
    echo   "<a href=\"$_SERVER[PHP_SELF]?offset=$prevoffset\"><< PREV</a> &nbsp; \n"; 
} 

// Now loop through the pages to create numbered links 
// ex. 1 2 3 4 5 NEXT >>
for ($i=1;$i<=$pages;$i++) { 
    // Check if on current page 
    if (($offset/$limit) == ($i-1)) { 
        // $i is equal to current page, so don't display a link 
        echo "$i &nbsp; "; 
    } else { 
        // $i is NOT the current page, so display a link to page $i 
        $newoffset=$limit*($i-1); 
        echo  "<a href=\"$_SERVER[PHP_SELF]?offset=$newoffset\">$i</a> &nbsp; \n"; 
    } 
} 
         
// Check to see if current page is last page 
if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
    // Not on the last page yet, so display a NEXT Link     
    $newoffset=$offset+$limit; 
    echo   "<a href=\"$_SERVER[PHP_SELF]?offset=$newoffset\">NEXT >></a><p>\n"; 
} 


oci_free_statement($stmt);

// Close the Oracle connection
oci_close($conn);
?>