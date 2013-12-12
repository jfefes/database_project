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
	<h1>Customers</h1>
	
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

			$fName = $_POST["fName"];
			$lName = $_POST["lName"];
			$idNo = $_POST["cust_id"];

			$sql='insert into customers(CUST_ID, F_NAME, L_NAME, FLIGHT_NUM, SEAT_NUM) values(:CUST_ID, :F_NAME, :L_NAME, null, null)';
			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ":F_NAME", $fName);
			oci_bind_by_name($stmt, ":L_NAME", $lName);
			oci_bind_by_name($stmt, ":CUST_ID", $idNo);

			if(oci_execute($stmt)) {
				echo "successful insert: <br/>
				$lName, $fName : as username $idNo";
			}
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