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
	<h1>Search employees</h1>
	<p style='text-align: center;'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Employee id (alphanumberic): <input type="text" name="em_id"><br>
			First name: <input type="text" name="fName"> <br/>
			Last name: <input type="text" name="lName"> <br/>
			Job title: <input type="text" name="title"><br>
			Salary: <input type="text" name="salary"><br>
			Job Assignment: <input type="text" name="assign"><br>
			<input type="submit" value="Search">
		</form>
		<br/>
		<?php
		if (isset($_POST["fName"]) || isset($_POST["assign"]) || isset($_POST["lName"])|| isset($_POST["em_id"]) || isset($_POST["title"]) || isset($_POST["salary"])){
			require_once("../Includes/db_connect.inc");
			
			$query=null;
			if (!$_POST["em_id"]==null){
				$employee_ID = $_POST["em_id"];
				$query = "EMPLOY_ID='$employee_ID'";
			}
			if (!$_POST["lName"]==null){
				$lName = $_POST["lName"];
				if(!$query==null)
					$query .= " AND L_NAME='$lName'";
				else
					$query = "L_NAME='$lName'";
			}
			
			if (!$_POST["fName"]==null){
				$fName = $_POST["fName"];
				if(!$query==null)
					$query .= " AND F_NAME='$fName'";
				else
					$query = "F_NAME='$fName'";
			}
			
			if (!$_POST["title"]==null){
				$title = $_POST["title"];
				if(!$query==null)
					$query .= " AND TITLE='$title'";
				else
					$query = "TITLE='$title'";
			}
			
			if (!$_POST["salary"]==null){ 
				$salary= $_POST["salary"];
				if(!$query==null)
					$query .= " AND SALARY='$salary'";
				else
					$query = "SALARY='$salary'";			
			}
			
			if (!$_POST["assign"]==null){
				$assign= $_POST["assign"]; 
				if(!$query==null)
					$query .= " AND ASSIGNMENT='$assign'";
				else
					$query = "ASSIGNMENT='$assign'";
			}
			
			if(!$query==null)
				$sql="select * from employees where $query";
			else
				$sql="select * from employees";
				
			$stmt = oci_parse($conn, $sql);

			
			oci_define_by_name($stmt, 'EMPLOY_ID', $em_ID);
			oci_define_by_name($stmt, 'L_NAME', $last);
			oci_define_by_name($stmt, 'F_NAME', $first);
			oci_define_by_name($stmt, 'TITLE', $job);
			oci_define_by_name($stmt, 'SALARY', $pay);
			oci_define_by_name($stmt, 'ASSIGNMENT', $flight);
			oci_execute($stmt);
			
			echo "
			<table border=1 align=center>
			<tr>
				<td> Employee ID </td>
				<td> Last Name </td>
				<td> First Name </td>
				<td> Job Title</td>
				<td> Salary </td>
				<td> Flight Assignment </td>
			</tr>";
			$i = 0;
			while (oci_fetch($stmt)) {
				if($flight==null) $flight="none";
				echo "
				<tr>
					<td> $em_ID </td>
					<td> $last </td>
					<td> $first </td>
					<td> $job </td>
					<td> $pay </td>
					<td> $flight </td>
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