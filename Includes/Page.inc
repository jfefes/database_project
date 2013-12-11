<?php
class Page
{
  private $title;
  public $dbConn;
  
  public function __construct()
  {
    $this->title = "";
  }
  
  // This function would be called after the session has been started
  public function addedPHPHeader()
  {
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function getTitle()
  {
    return $this->title;
  }
  
  protected function setTitle($title)
  {
    $this->title = $title;
  }
 
  public function pageContent($printerFriendly)
  {
  }
  
  public function pageEnd()
  {
  }
  
  public function dbConn(){
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
	};
  }
  
  public function sql($statement){
	$statement = oci_parse($dbConn, $statement);
	oci_execute($statement);
  }
  
}
?>