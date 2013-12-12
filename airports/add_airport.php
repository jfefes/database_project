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