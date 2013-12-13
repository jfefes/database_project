<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Add Customer(s)");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Add Customer(s)</h1>
	
	<p style='text-align: center;'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			First Name: <input type="text" name="fName"> <br/>
			Last Name: <input type="text" name="lName"> <br/>
			Customer ID (alphanumeric): <input type="text" name="cust_id"><br>
			<input type="submit" value="Submit">
		</form>
		<br/>
		<?php
		if (isset($_POST["fName"]) && isset($_POST["lName"])&& isset($_POST["cust_id"])){
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
			$cust_id = $_POST["cust_id"];

			$sql='insert into customers(CUST_ID, F_NAME, L_NAME) values(:CUST_ID, :F_NAME, :L_NAME)';
			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ":L_NAME", $lName);
			oci_bind_by_name($stmt, ":F_NAME", $fName);
			oci_bind_by_name($stmt, ":CUST_ID", $cust_id);

			if(oci_execute($stmt)) {
				echo "Customer added: <br/>
				$fName, $lName, with Customer ID $cust_id";
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