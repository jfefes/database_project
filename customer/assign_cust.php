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
	<h1>Reserve a flight as a customer</h1>
	<p style='text-align: center;'>	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Enter customer ID: <input type="text" name="customer"><br>
			Enter flight number: <input type="text" name="flight"><br>
			<input type="submit" value="Assign">
		</form>
		<br/>
		<?php
		if (isset($_POST["flight"]) && !$_POST["customer"]==null){
			require_once("../Includes/db_connect.inc");

			$customer = $_POST["customer"];
			$customer = "CUST_ID='$customer'";
			$flightNew = $_POST["flight"];
			
			
			$sql="select * from customers where $customer";
			$stmt = oci_parse($conn, $sql);
			
			oci_define_by_name($stmt, 'CUST_ID', $customer_ID);
			oci_define_by_name($stmt, 'L_NAME', $last);
			oci_define_by_name($stmt, 'F_NAME', $first);
			oci_define_by_name($stmt, 'FLIGHT_NUM', $flightOld);
			oci_define_by_name($stmt, 'SEAT_NUM', $seatOld);
			oci_execute($stmt);
			oci_fetch($stmt);
			
			$sqlB="select EN_ROUTE from flights where FLIGHT_NUM='$flightOld'";
			$stmtB = oci_parse($conn, $sqlB);
			oci_define_by_name($stmtB, 'EN_ROUTE', $enRouteOld);
			oci_execute($stmtB);
			oci_fetch($stmtB);
			
			
			$sqlC="select EN_ROUTE from flights where FLIGHT_NUM='$flightNew'";
			$stmtC = oci_parse($conn, $sqlC);
			oci_define_by_name($stmtC, 'EN_ROUTE', $enRouteNew);
			oci_execute($stmtC);
			oci_fetch($stmtC);
			
			if($flightOld==null) $flightOld="(none)";
			
			if(!$enRouteNew && !$enRouteOld){
				echo "Flight info updated! <br/>
				customer ID $customer_ID: $last, $first <br/>
				old flight assignment: $flightOld <br/>
				new flight assignment: $flightNew";
				
				$assignSql='update customers set flight_num=:NEW_FLIGHT where cust_id=:CUST_ID';
	
				$assignStmt = oci_parse($conn, $assignSql);
				
				oci_bind_by_name($assignStmt, ":NEW_FLIGHT", $flightNew);
				oci_bind_by_name($assignStmt, ":CUST_ID", $customer_ID);
				oci_execute($assignStmt, OCI_COMMIT_ON_SUCCESS);
				
				oci_free_statement($assignStmt);
			}
			else if($enRouteOld) echo "ERROR: Cannot assign new flight! <br/> Current flight is in progress.";
			else if($enRouteNew) echo "ERROR: Cannot change to this flight! <br/> Target flight is in progress.";
						
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