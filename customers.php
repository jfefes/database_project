<?php
require_once("/Includes/Page.inc");
require_once("/Includes/Site.inc");

$dbHost = "141.238.32.126";
$dbHostPort="1521";
$dbServiceName = "xe";
$usr = "fefes";
$pswd = "password";
$dbConnStr = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
			(HOST=".$dbHost.")(PORT=".$dbHostPort."))
			(CONNECT_DATA=(SERVICE_NAME=".$dbServiceName.")))";
		
			
if(!$dbConn = oci_connect($usr,$pswd,$dbConnStr)){
	$err = oci_error();
	trigger_error('Could not establish a connection to Oracle');
}

  function sql($string){
  $dbHost = "141.238.32.126";
$dbHostPort="1521";
$dbServiceName = "xe";
$usr = "morrison";
$pswd = "password";
$dbConnStr = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
			(HOST=".$dbHost.")(PORT=".$dbHostPort."))
			(CONNECT_DATA=(SERVICE_NAME=".$dbServiceName.")))";
  $dbConn = oci_connect($usr,$pswd,$dbConnStr);	
	$statement = oci_parse($dbConn, $string);
	oci_execute($statement);
  }		

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Customers");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Customers</h1>
	
	<p style='text-align: center;'>
		<?php echo sql("select * from branch"); ?> <br/>
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

require_once("/Includes/template.tpl");
?>