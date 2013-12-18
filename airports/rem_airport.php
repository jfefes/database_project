<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Remove Airport");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Remove an airport</h1>
	<p style='text-align: center;'>	
	<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			Remove an airport by entering the port id: <input type="text" name="remove_airport"><br>
			<input type="submit" value="Delete">
		</form>
		<br/>
		<?php
		if (isset($_POST["remove_airport"]) && !$_POST["remove_airport"]==null){
			require_once("../Includes/db_connect.inc");
						
			if(!$conn = oci_connect($usr,$pswd,$dbConnStr)){
				$err = oci_error();
				trigger_error('Could not establish a connection to Oracle');
			}

			$port_ID = $_POST["remove_airport"];
			$port_ID = "PID='$port_ID'";
			
			
			$sql="select * from airports where $port_ID";
			$stmt = oci_parse($conn, $sql);
			
			oci_define_by_name($stmt, 'PID', $pid);
			oci_define_by_name($stmt, 'LOC_CITY', $city);
			oci_define_by_name($stmt, 'LOC_STATE', $state);
			oci_execute($stmt);
			
			
			if(oci_fetch($stmt)) {
				echo "Airport removed: <br/>
				Port ID $pid: located in $city, $state.";
			}
			$sql="delete from airports where $port_ID";
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