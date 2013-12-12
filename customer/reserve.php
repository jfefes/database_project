<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Register as new customer");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1> Reserve a flight </h1>
	<p style='text-align: center;'>
		
		
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
				
			$sql = "Select count(*) from flights";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt);
			$total_rows = oci_fetch_array($stmt);
			if ( !$total_rows[0] ) {
				echo "<h1>Error - no rows returned!</h1>";
				exit;
			}
			oci_free_statement($stmt);

			$sql = "Select * from flights";
			$stmt = oci_parse($conn, $sql);
			if(!$stmt) {
				echo "<h1>ERROR - Could not parse SQL statement.</h1>";
				exit;
			}
			
			echo "There are <b>$total_rows[0]</b> available flights. <br> <br>\n";
			
			
			oci_define_by_name($stmt, 'FLIGHT_NUM', $flightId);
			oci_define_by_name($stmt, 'GATE_C', $gateCurr);
			oci_define_by_name($stmt, 'SEATS_MAX', $seatsMax);
			oci_define_by_name($stmt, 'SEATS_LEFT', $seatsLeft);
			oci_define_by_name($stmt, 'DEPARTURE_T', $departDate);
			oci_define_by_name($stmt, 'ARRIVAL_T', $arriveDate);

			oci_execute($stmt);
			
			echo "
			<table border=1 align=center>
			<tr>
				<td> Flight number </td>
				<td> Gate </td>
				<td> Seats left </td>
				<td> Departure Time </td>
				<td> Arrival Time </td>
			</tr>";
			$i = 0;
			while (oci_fetch($stmt)) {
				//$flights[$i][0] = $flightId;
				//<td> var_dump($flights[$i][0]) </td>
				echo "
				<tr>
					<td> $flightId </td>
					<td> $gateCurr </td>
					<td> $seatsLeft </td>
					<td> $departDate </td>
					<td> $arriveDate </td>
				</tr>";					
				$i++;
			}
			echo "</table>";
		?> 
			 
	</p>
</div>


<?php
	oci_free_statement($stmt);
	
	// Close the Oracle connection
	oci_close($conn);
  }
  
  public function pageEnd()
  {
?>
<?php
  }
}

$page = new CurrentPage();

require_once("../Includes/template.tpl");

?>