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
  <h1>CSIT 455 Project</h1>
</div>
<div style= 'float: left;'>
  Please choose an item within a submenu to access a new page.
</div>

<div style= 'height: 1px; clear: both'>
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
