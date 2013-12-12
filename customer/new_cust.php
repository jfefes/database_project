<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Register as new customer");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Customers</h1
	
	<p style='text-align: center;'>
		Note: Other Customer options located within the sub-menu. 
		 <br/>
		 <h2>Register as a new customer: </h2>
		 
		 <form action="cust_success.php" method="post">
			Name: <input type="text" name="fName"> &nbsp; &nbsp; &nbsp;	Last Name: <input type="text" name="lName"><br>
			Username (alphanumeric): <input type="text" name="cust_id"><br>
			<input type="submit" value="Submit">
		</form>
		 
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