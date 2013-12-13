<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Search Airport(s)");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Search Airport(s)</h1>
	<p style='text-align: center;'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Port ID (alphanumberic): <input type="text" name="port_id"><br>
			City: <input type="text" name="city"> <br/>
			State (abbr.): <input type="text" name="state"> <br/>
			<input type="submit" value="Search">
		</form>
		<br/>
		<?php
		if (isset($_POST["port_id"]) || isset($_POST["city"])|| isset($_POST["state"])){
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
			
			
			$query=null;
			if (!$_POST["port_id"]==null){
				$port_ID = $_POST["port_id"];
				$query = "PID='$port_ID'";
			}
			if (!$_POST["city"]==null){
				$city = $_POST["city"];
				if(!$query==null)
					$query .= " AND LOC_CITY='$city'";
				else
					$query = "LOC_CITY='$city'";
			}
			
			if (!$_POST["state"]==null){
				$state = $_POST["state"];
				if(!$query==null)
					$query .= " AND LOC_STATE='$state'";
				else
					$query = "LOC_STATE='$state'";
			}
			
			if(!$query==null)
				$sql="select * from airports where $query";
			else
				$sql="select * from airports";
				
			$stmt = oci_parse($conn, $sql);

			
			oci_define_by_name($stmt, 'PID', $pid);
			oci_define_by_name($stmt, 'LOC_CITY', $loc_city);
			oci_define_by_name($stmt, 'LOC_STATE', $loc_state);
			oci_execute($stmt);
			
			echo "
			<table border=1 align=center>
			<tr>
				<td> Port ID </td>
				<td> City </td>
				<td> State </td>
			</tr>";
			$i = 0;
			while (oci_fetch($stmt)) {
				echo "
				<tr>
					<td> $pid </td>
					<td> $loc_city </td>
					<td> $loc_state </td>
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