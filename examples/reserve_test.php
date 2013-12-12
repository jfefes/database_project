<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Register as new customer");
		$dbHost = "141.238.32.126";
	$dbHostPort="1521";
	$dbServiceName = "xe";
	$usr = "andrew";
	$pswd = "password";
	$dbConnStr = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
				(HOST=".$dbHost.")(PORT=".$dbHostPort."))
				(CONNECT_DATA=(SERVICE_NAME=".$dbServiceName.")))";
	global $conn;		
				
	if(!$conn = oci_connect($usr,$pswd,$dbConnStr)){
		$err = oci_error();
		trigger_error('Could not establish a connection to Oracle');
	}
	
	$sql = "Select count(*) from flights";
	$stmt = oci_parse($conn, $sql);
	oci_execute($stmt);



	$total_rows = oci_fetch_array($stmt);
		
	if ( !$total_rows[0] ) {
		echo "<h1>Error - no rows returned!</h1>";
		exit;
	}
	echo "<br>There are <b>$total_rows[0]</b> results. <br> <br>\n";
	oci_free_statement($stmt);

	$sql = "Select flight_num,gate_c,seats_max,seats_left from flights";
		
	$stmt = oci_parse($conn, $sql);

	if(!$stmt) {
		echo "<h1>ERROR - Could not parse SQL statement.</h1>";
		exit;
	}

	// The defines MUST be done before executing
	oci_define_by_name($stmt, 'FLIGHT_NUM', $flightId);
	oci_define_by_name($stmt, 'GATE_C', $flightGate);
	oci_define_by_name($stmt, 'SEATS_MAX', $flightSeats);
	oci_define_by_name($stmt, 'SEATS_LEFT', $remainingSeats);

	oci_execute($stmt);
	global $result;
	$result = "$flightId leaving from gate $flightGate has $remainingSeats seats left. <br>\n";

	oci_fetch($stmt);

	/*while (oci_fetch($stmt)) {
		"Flight: $flightId leaving from gate $flightGate has $remainingSeats seats left. <br>\n";
	}*/

	oci_free_statement($stmt);

	
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Customers</h1>
	
	<p style='text-align: center;'>
		<h2> <?php echo $result ?> </h2> 
				 
	</p>
</div>


<?php
  }
  
  public function pageEnd()
  {
?>
<?php
  }
}

$page = new CurrentPage();

require_once("../Includes/template.tpl");
// Close the Oracle connection
	oci_close($conn);
?>