<?php
require_once("../Includes/Page.inc");
require_once("../Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Airports");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>
<div style='text-align: center;'>
	<h1>Airports</h1>
	
	<p style='text-align: center;'>
		Please use Airports options located within the sub-menu. 		 
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