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
	<h1>Assign flight to employee</h1>
	<p style='text-align: center;'>	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Enter employee id: <input type="text" name="employee"><br>
			Enter flight number: <input type="text" name="flight"><br>
			<input type="submit" value="Assign">
		</form>
		<br/>
		<?php
		if (isset($_POST["flight"]) && !$_POST["employee"]==null){
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

			$employee = $_POST["employee"];
			$employee_ID = "EMPLOY_ID='$employee'";
			$flight_id = $_POST["flight"];
			
			
			$sql="select EMPLOY_ID,L_NAME,F_NAME,ASSIGNMENT from employees where $employee_ID";
			$stmt = oci_parse($conn, $sql);
			
			oci_define_by_name($stmt, 'EMPLOY_ID', $em_ID);
			oci_define_by_name($stmt, 'L_NAME', $last);
			oci_define_by_name($stmt, 'F_NAME', $first);
			oci_define_by_name($stmt, 'ASSIGNMENT', $assignOld);
			oci_execute($stmt);
			
			
			$sqlB="select EN_ROUTE from flights where FLIGHT_NUM='$flight_id'";
			$stmtB = oci_parse($conn, $sqlB);
			oci_define_by_name($stmtB, 'EN_ROUTE', $enRoute);
			oci_execute($stmtB);
			echo $enRoute;
			
			if(oci_fetch($stmt) && oci_fetch($stmtB)) {
				if($assignOld==null) $assignOld="(none)";
					if(!$enRoute){
						echo "Assignment updated: <br/>
						Employee ID $em_ID: $last, $first <br/>
						old flight assignment: $assignOld <br/>
						new flight assignment: $flight_id";
					}
					else echo "ERROR: Cannot assign job! <br/> Flight is in progress.";
			}
			
			
			$assignSql='update employees set assignment=:ASSIGNMENT where employ_id=:EMPLOY_ID';
			
			$assignStmt = oci_parse($conn, $assignSql);
			
			oci_bind_by_name($assignStmt, ":ASSIGNMENT", $flight_id);
			oci_bind_by_name($assignStmt, ":EMPLOY_ID", $employee);
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