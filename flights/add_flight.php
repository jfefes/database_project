<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Add Flight(s)");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Add a new flight</h1>
	
	<p style='text-align: center;'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Flight ID (3 num, 1 char): <input type="text" name="flight_id"> <br/>
			Leaving from: <input type="text" name="dest"> <br/>
			Destination: <input type="text" name="curr"><br/>
			Departure (DD-MMM-YY HH-MM AM/PM): <input type="text" name="dTime"><br/>
			Arrival (DD-MMM-YY HH-MM AM/PM): <input type="text" name="aTime"><br/>
			Gate: <input type="text" name="curr_gate"><br/>
			Arriving Gate: <input type="text" name="dest_gate"><br/>
			Maximum Seats: <input type="text" name="seats"><br/>
		<input type="submit" value="Submit">
		</form>
		<br/>
		<?php
		if (isset($_POST["flight_id"]) && isset($_POST["dest"])&& isset($_POST["curr"]) && isset($_POST["dTime"]) && isset($_POST["aTime"]) && isset($_POST["curr_gate"])&& isset($_POST["seats"])){
			require_once("../Includes/db_connect.inc");
			
			$timeStamp;
			$flight_id = $_POST["flight_id"];
			$dest = $_POST["dest"];
			$curr = $_POST["curr"];
			$dTime = $_POST["dTime"];
				$timeStamp = substr($dTime, -2);
				$dTime = substr($dTime, 0, 15);
				$dTime .= ".00.000000000 " .$timeStamp;
			$aTime = $_POST["aTime"];
				$timeStamp = substr($aTime, -2);
				$aTime = substr($aTime, 0, 15);
				$aTime .= ".00.000000000 " .$timeStamp;
			$curr_gate = $_POST["curr_gate"];
			$dest_gate = $_POST["dest_gate"];
			$seats = $_POST["seats"];
			$onGround = 0;
			
			$sql='insert into flights(FLIGHT_NUM, DEST_PORT_ID, CURR_PORT_ID, DEPARTURE_T, ARRIVAL_T, EN_ROUTE, GATE_C, GATE_D, SEATS_MAX, SEATS_LEFT) values(:FLIGHT_NUM, :DEST_PORT_ID, :CURR_PORT_ID, :DEPARTURE_T, :ARRIVAL_T, :EN_ROUTE, :GATE_D, :GATE_C, :SEATS_MAX, :SEATS_LEFT)';
			$stmt = oci_parse($conn, $sql);

			
			oci_bind_by_name($stmt, ":FLIGHT_NUM", $flight_id);
			oci_bind_by_name($stmt, ":DEST_PORT_ID", $dest);
			oci_bind_by_name($stmt, ":CURR_PORT_ID", $curr);
			oci_bind_by_name($stmt, ":DEPARTURE_T", $dTime);
			oci_bind_by_name($stmt, ":ARRIVAL_T", $aTime);
			oci_bind_by_name($stmt, ":EN_ROUTE", $onGround);
			oci_bind_by_name($stmt, ":GATE_C", $curr_gate);
			oci_bind_by_name($stmt, ":GATE_D", $dest_gate);
			oci_bind_by_name($stmt, ":SEATS_MAX", $seats);
			oci_bind_by_name($stmt, ":SEATS_LEFT", $seats);

			if(oci_execute($stmt)) {
				$dTime = substr($dTime, 0, -13) .substr($dTime, -2);
				$aTime = substr($aTime, 0, -13) .substr($aTime, -2);
				echo "Flight created: <br/>
				Flight id number $flight_id <br/>
				Leaving from Port ID $dest and going to $curr <br/>
				Will depart from gate $curr_gate at $dTime <br/>
				Will arrive at gate $dest_gate at $aTime <br/>
				Maximum of $seats customers";
			}
		}
		?>	 
	</p>
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