 class databse_connect
 (
 
 public function dbConn()
 {
	$dbHost = "141.238.32.126";
	$dbHostPort="1521";
	$dbServiceName = "xe";
	$usr = "fefes";
	$pswd = "password";
	$dbConnStr = "(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)
				(HOST=".$dbHost.")(PORT=".$dbHostPort."))
				(CONNECT_DATA=(SERVICE_NAME=".$dbServiceName.")))";


	if(!$dbConn = oci_connect($usr,$pswd,$dbConnStr)){
	$m = oci_error();
    return $m['message'], "\n";
	};
}
  
  public function sql($statement){
	$statement = oci_parse($dbConn, $statement);
	oci_execute($statement);
  }
  
 }