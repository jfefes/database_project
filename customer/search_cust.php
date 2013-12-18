<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Search Customer(s)");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Search Customer</h1>
	<p style='text-align: center;'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			First Name: <input type="text" name="fName"> <br/>
			Last Name: <input type="text" name="lName"> <br/>
			Customer ID (alphanumeric): <input type="text" name="cust_id"><br>
			<input type="submit" value="Search">
		</form>
		<br/>
		<?php
		if (isset($_POST["fName"]) || isset($_POST["lName"])|| isset($_POST["cust_id"])){
			require_once("../Includes/db_connect.inc");
			
			$query=null;
			if (!$_POST["cust_id"]==null){
				$cust_id = $_POST["cust_id"];
				$query = "CUST_ID='$cust_id'";
			}
			if (!$_POST["fName"]==null){
				$fName = $_POST["fName"];
				if(!$query==null)
					$query .= " AND F_NAME='$fName'";
				else
					$query = "F_NAME='$fName'";
			}
			
			if (!$_POST["lName"]==null){
				$lName = $_POST["lName"];
				if(!$query==null)
					$query .= " AND L_NAME='$lName'";
				else
					$query = "L_NAME='$lName'";
			}
			
			if(!$query==null)
				$sql="select * from customers where $query";
			else
				$sql="select * from customers";
				
			$stmt = oci_parse($conn, $sql);

			
			oci_define_by_name($stmt, 'CUST_ID', $cust);
			oci_define_by_name($stmt, 'F_NAME', $fName);
			oci_define_by_name($stmt, 'L_NAME', $lName);
			oci_define_by_name($stmt, 'FLIGHT_NUM', $flight);
			oci_define_by_name($stmt, 'SEAT_NUM', $seat);
			oci_execute($stmt);
			
			echo "
			<table border=1 align=center>
			<tr>
				<td> Customer ID </td>
				<td> First Name </td>
				<td> Last Name </td>
				<td> Flight </td>
				<td> Seat Number </td>
			</tr>";
			while (oci_fetch($stmt)) {
				if($flight==null) $flight="(none)";
				if($seat==null) $seat="(none)";
				echo "
				<tr>
					<td> $cust </td>
					<td> $fName </td>
					<td> $lName </td>
					<td> $flight </td>
					<td> $seat </td>
				</tr>";
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