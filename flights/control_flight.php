<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Assign Employee Job");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Taken off/Landed</h1>
	<p style='text-align: center;'>	
	Assign this binary value. A plane that has taken off and not yet landed cannot have related data alerted until the plane has landed.
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Enter flight number: <input type="text" name="flight"><br>
			<input type="submit" value="Commit">
		</form>
		<br/>
		<?php
		if (isset($_POST["flight"]) && !$_POST["flight"]==null){
			require_once("../Includes/db_connect.inc");

			$flight = $_POST["flight"];
			$flight = "FLIGHT_NUM='$flight'";
			
			$sqlA="select FLIGHT_NUM,EN_ROUTE,DEST_PORT_ID from flights where $flight";
			$stmtA = oci_parse($conn, $sqlA);
			oci_define_by_name($stmtA, 'FLIGHT_NUM', $flight_id);
			oci_define_by_name($stmtA, 'EN_ROUTE', $enRoute);
			oci_define_by_name($stmtA, 'DEST_PORT_ID', $dest);
			
			oci_execute($stmtA);
			oci_fetch($stmtA);
			
			$sqlB="select PID,LOC_CITY,LOC_STATE from airports where PID='$dest'";
			$stmtB = oci_parse($conn, $sqlB);
			
			oci_define_by_name($stmtB, 'LOC_CITY', $city);
			oci_define_by_name($stmtB, 'LOC_STATE', $state);
			
			oci_execute($stmtB);
			
			if(oci_fetch($stmtB)) {
				if(!$enRoute) {
					$enRoute="1";
					echo "Flight updated: <br/>
					Flight $flight_id has taken off<br/>
					towards Port $dest in $city, $state<br/>";
				}
				else if($enRoute) {
					$enRoute=0;
					echo "Flight updated: <br/>
					Flight $flight_id has landed<br/>
					at Port ID $dest in $city, $state<br/>";
				}
			}
			
			$assignSql='update flights set EN_ROUTE=:ENROUTE where FLIGHT_NUM=:FLIGHT_NUM';
			
			$assignStmt = oci_parse($conn, $assignSql);
			
			oci_bind_by_name($assignStmt, ":ENROUTE", $enRoute);
			oci_bind_by_name($assignStmt, ":FLIGHT_NUM", $flight_id);
			oci_execute($assignStmt, OCI_COMMIT_ON_SUCCESS);
			
			
			oci_free_statement($assignStmt);
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