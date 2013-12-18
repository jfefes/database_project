<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Add Airport(s)");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Add Airport(s)</h1>
	
	<p style='text-align: center;'>
		<form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post">
			City location: <input type="text" name="city"> <br/>
			State (2 letter abbreviation): <input type="text" name="state"> <br/>
			Airport id: <input type="text" name="airport_id"><br>
			<input type="submit" value="Submit">
		</form>
		<br/>
		<?php
		if (isset($_POST["city"]) && isset($_POST["state"])&& isset($_POST["airport_id"])){
			require_once("../Includes/db_connect.inc");
			
			$city = $_POST["city"];
			$state = $_POST["state"];
			$port_ID = $_POST["airport_id"];

			$sql='insert into airports(PID, LOC_CITY, LOC_STATE) values(:PID, :CITY, :STATE)';
			$stmt = oci_parse($conn, $sql);

			oci_bind_by_name($stmt, ":STATE", $state);
			oci_bind_by_name($stmt, ":CITY", $city);
			oci_bind_by_name($stmt, ":PID", $port_ID);

			if(oci_execute($stmt)) {
				echo "Airport added: <br/>
				in $city, $state : with PID $port_ID";
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