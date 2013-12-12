<?php
require_once("/Includes/Page.inc");
require_once("/Includes/Site.inc");

class CurrentPage extends Page
{
  public function __construct()
  {
    parent::setTitle("Home");
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function pageContent($printerFriendly)
  {
?>


<div style='text-align: center;'>
	Text goes here. This page is designed to be a starting place for new pages, and not part of the final product.
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