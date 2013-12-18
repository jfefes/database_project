<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Cancel a flight");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Cancel a flight</h1>
	<p style='text-align: center;'>	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Cancel a flight by entering the flight id: <input type="text" name="cancel_flight"><br>
			<input type="submit" value="Delete">
		</form>
		<br/>
		<?php
		if (isset($_POST["cancel_flight"]) && !$_POST["cancel_flight"]==null){
			require_once("../Includes/db_connect.inc");

			$cancel_flight = $_POST["cancel_flight"];
			$cancel_flight = "FLIGHT_NUM='$cancel_flight'";
			
			
			$sql="select * from flights where $cancel_flight";
			$stmt = oci_parse($conn, $sql);
			
			oci_define_by_name($stmt, "FLIGHT_NUM", $flight_id);
			oci_define_by_name($stmt, "DEST_PORT_ID", $dest);
			oci_define_by_name($stmt, "CURR_PORT_ID", $curr);
			oci_define_by_name($stmt, "DEPARTURE_T", $dTime);
			oci_define_by_name($stmt, "ARRIVAL_T", $aTime);
			oci_define_by_name($stmt, "EN_ROUTE", $onGround);
			oci_define_by_name($stmt, "GATE_C", $curr_gate);
			oci_define_by_name($stmt, "GATE_D", $dest_gate);
			oci_define_by_name($stmt, "SEATS_MAX", $seatsMax);
			oci_define_by_name($stmt, "SEATS_LEFT", $seatsLeft);
			oci_execute($stmt);
			
			
			
			if(oci_fetch($stmt)) {
				echo "Flight cancelled: <br/>
				Flight id number $flight_id <br/>
				Planned departure from Port ID $dest and going to $curr <br/>
				Would depart from gate $curr_gate at $dTime <br/>
				Would arrive at gate $dest_gate at $aTime <br/>
				Had maximum of $seatsMax customers";
			}
			$sql="delete from flights where $cancel_flight";
			$stmt = oci_parse($conn, $sql);
			oci_execute($stmt, OCI_COMMIT_ON_SUCCESS);
		}
		?>	 	
</div>


<?php
	if(isset($conn) && isset($stmt) && !$stmt==null){
		oci_free_statement($stmt);
		oci_close($conn);
	}
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