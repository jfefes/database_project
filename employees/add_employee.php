<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Add Employee(s)");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Add Employee(s)</h1>
	
	<p style='text-align: center;'>
		Add new employee(s) here.		 
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