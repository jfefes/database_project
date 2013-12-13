<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Remove Employee");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Remove an employee</h1>
	<p style='text-align: center;'>	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Remove an employee by entering their employee id: <input type="text" name="remove_employee"><br>
			<input type="submit" value="Delete">
		</form>
		<br/>
		<?php
		if (isset($_POST["remove_employee"]) && !$_POST["remove_employee"]==null){
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

			$employee_ID = $_POST["remove_employee"];
			$employee_ID = "EMPLOY_ID='$employee_ID'";
			
			
			$sql="select * from employees where $employee_ID";
			$stmt = oci_parse($conn, $sql);
			
			oci_define_by_name($stmt, 'EMPLOY_ID', $em_ID);
			oci_define_by_name($stmt, 'L_NAME', $last);
			oci_define_by_name($stmt, 'F_NAME', $first);
			oci_define_by_name($stmt, 'TITLE', $job);
			oci_define_by_name($stmt, 'SALARY', $pay);
			oci_define_by_name($stmt, 'ASSIGNMENT', $flight);
			oci_execute($stmt);
			
			
			if(oci_fetch($stmt)) {
				if($flight==null) $flight="(none)";
				echo "Employee removed: <br/>
				Job ID $em_ID: $last, $first <br/>
				worked as a $job with salary of $pay. <br/>
				Flight assignment: $flight";
			}
			$sql="delete from employees where $employee_ID";
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