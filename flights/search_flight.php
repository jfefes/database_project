<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Search Employee(s)");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Search flights</h1>
	<p style='text-align: center;'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Flight ID (3 num, 1 char): <input type="text" name="flight_id"> <br/>
			Leaving from: <input type="text" name="dest"> <br/>
			Destination: <input type="text" name="curr"><br/>
			Departure (DD-MMM-YY HH.MM AM/PM): <input type="text" name="dTime"><br/>
			Arrival (DD-MMM-YY HH.MM AM/PM): <input type="text" name="aTime"><br/>
			<input type="submit" value="Search">
		</form>
		<br/>
		<?php
		if (isset($_POST["flight_id"]) || isset($_POST["dest"]) || isset($_POST["curr"])|| isset($_POST["dTime"]) || isset($_POST["aTime"])){
			require_once("../Includes/db_connect.inc");
			
			
			$query=null;
			if (!$_POST["flight_id"]==null){
				$flight_id = $_POST["flight_id"];
				$query = "FLIGHT_NUM='$flight_id'";
			}
			if (!$_POST["dest"]==null){
				$dest = $_POST["dest"];
				if(!$query==null)
					$query .= " AND DEST_PORT_ID='$dest'";
				else
					$query = "DEST_PORT_ID='$dest'";
			}
			
			if (!$_POST["curr"]==null){
				$curr = $_POST["curr"];
				if(!$query==null)
					$query .= " AND CURR_PORT_ID='$curr'";
				else
					$query = "CURR_PORT_ID='$curr'";
			}
			
			if (!$_POST["dTime"]==null){ 
				$dTime= $_POST["dTime"];
				$AMPM = substr($dTime, -2);
				$dTime = substr($dTime, 0, 15);
				$dTime .= ".00.000000000 " .$AMPM;
				if(!$query==null)
					$query .= " AND DEPARTURE_T='$dTime'";
				else
					$query = "DEPARTURE_T='$dTime'";			
			}
			
			if (!$_POST["aTime"]==null){
				$aTime= $_POST["aTime"];
				$AMPM = substr($aTime, -2);
				$aTime = substr($aTime, 0, 15);
				$aTime .= ".00.000000000 " .$AMPM;				
				if(!$query==null)
					$query .= " AND ARRIVAL_T='$aTime'";
				else
					$query = "ARRIVAL_T='$aTime'";
			}
			
			if(!$query==null)
				$sql="select * from flights where $query";
			else
				$sql="select * from flights";
				
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
			
			echo "
			<table border=1 align=center>
			<tr>
				<td> Flight ID </td>
				<td> Destination Port </td>
				<td> Current Port </td>
				<td> Departure</td>
				<td> Arrival </td>
				<td> In flight? </td>
				<td> Departure Gate </td>
				<td> Arrival Gate </td>
				<td> Maximum customers</td>
				<td> Remaining seats</td>
			</tr>";
			$i = 0;
			while (oci_fetch($stmt)) {
				if($onGround==0) $onGround="No";
				if($onGround==1) $onGround="Yes";
				$dTime = substr($dTime, 0, -6) ." " .substr($dTime, -2);
				$aTime = substr($aTime, 0, -6) ." " .substr($aTime, -2);
				echo "
				<tr>
					<td> $flight_id </td>
					<td> $dest </td>
					<td> $curr </td>
					<td> $dTime </td>
					<td> $aTime </td>
					<td> $onGround </td>
					<td> $curr_gate </td>
					<td> $dest_gate </td>
					<td> $seatsMax </td>
					<td> $seatsLeft </td>
				</tr>";					
				$i++;
			}
			echo "</table>";
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