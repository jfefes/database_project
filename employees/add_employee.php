<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Add Employee(s)");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Add an employee</h1>
	
	<p style='text-align: center;'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			First name: <input type="text" name="fName"> <br/>
			Last name: <input type="text" name="lName"> <br/>
			Job title: <input type="text" name="title"><br>
			Salary: <input type="text" name="salary"><br>
			Employee id (alphanumberic): <input type="text" name="em_id"><br>
			<input type="submit" value="Submit">
		</form>
		<br/>
		<?php
		if (isset($_POST["fName"]) && isset($_POST["lName"])&& isset($_POST["em_id"]) && isset($_POST["title"])&& isset($_POST["salary"])){
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

			$employee_ID = $_POST["em_id"];
			$last = $_POST["lName"];
			$first = $_POST["fName"];
			$title = $_POST["title"];
			$salary= $_POST["salary"];
			
			$sql='insert into employees(EMPLOY_ID, L_NAME, F_NAME, TITLE, SALARY) values(:EMPLOY_ID, :L_NAME, :F_NAME, :TITLE, :SALARY)';
			$stmt = oci_parse($conn, $sql);

			
			oci_bind_by_name($stmt, ":EMPLOY_ID", $employee_ID);
			oci_bind_by_name($stmt, ":L_NAME", $last);
			oci_bind_by_name($stmt, ":F_NAME", $first);
			oci_bind_by_name($stmt, ":TITLE", $title);
			oci_bind_by_name($stmt, ":SALARY", $salary);

			if(oci_execute($stmt)) {
				echo "Employee added: <br/>
				$first $last: as a $title with ID $employee_ID, and salary of $salary";
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