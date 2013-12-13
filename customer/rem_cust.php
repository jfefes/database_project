<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Delete Customer");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Delete a customer</h1>
	<p style='text-align: center;'>	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Delete customer by entering their id: <input type="text" name="remove_customer"><br>
			<input type="submit" value="Delete">
		</form>
		<br/>
		<?php
		if (isset($_POST["remove_customer"]) && !$_POST["remove_customer"]==null){
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

			$cust_ID = $_POST["remove_customer"];
			$cust_ID = "CUST_ID='$cust_ID'";
			
			
			$sql="select * from customers where $cust_ID";
			$stmt = oci_parse($conn, $sql);
			
			oci_define_by_name($stmt, 'CUST_ID', $cust);
			oci_define_by_name($stmt, 'F_NAME', $fName);
			oci_define_by_name($stmt, 'L_NAME', $lName);
			oci_define_by_name($stmt, 'FLIGHT_NUM', $flight);
			oci_define_by_name($stmt, 'SEAT_NUM', $seat);
			oci_execute($stmt);
			
			
			if(oci_fetch($stmt)) {
				if($flight==null) $flight="(none)";
				if($seat==null) $seat="(none)";
				echo "Customer removed: <br/>
				$lName, $fName: with ID cust <br/>
				on flight $flight in seat $seat";
			}
			$sql="delete from customers where $cust_ID";
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