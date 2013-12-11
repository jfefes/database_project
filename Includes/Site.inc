<script>
function openWindow( url )
	{
	  window.open(url, '_blank');
	}
</script>

<?php
include_once("Menu.inc");
include_once("MenuItem.inc");
class SiteMenu extends Menu
{
  public function __construct()
  {
    parent::__construct();
  }
  
  public function generateMenu($elementId = "", $elementClass = "", $itemClass = "")
  {
?>
<ul id="<?php echo $elementId; ?>" class="<?php echo $elementClass; ?>">
<?php
    $items = self::getItems();
    for($i = 0; $i < count($items); ++$i)
    {
      $item = $items[$i];
      $subMenu = $item->getSubMenu();
?>
  <li class="<?php echo $itemClass; ?>">
  <a href="<?php echo $item->getUrl(); ?>" 
  <?php if($item->getOpenNewTab()){?>
  onclick="javascript:openWindow(this.href);return false;" <?php } ?>
  > 
  <?php echo $item->getText(); ?></a>
<?php
      if(null !== $subMenu)
      { 
		$subMenu->generateMenu("", "", $itemClass);
      }
	  
?>
  </li>
<?php
    }
?>
</ul>
<?php
  }
}

class Site
{
  private static $prefix = "/trunk/";
  private static $menu;
  static function init(){
  
	//Menu->addItem(new MenuItem("name", url, subMenu, newTab, id);
    
	$customerSubMenu = new SiteMenu();
	//$customerSubMenu->addItem("Reservations", "customers.php");
	//$customerSubMenu->addItem("Review/Edit", "customers.php");
	
	$employeeSubMenu = new SiteMenu();
//	$employeeSubMenu->addItem("Assigned jobs", SITEURL_FIX_LATER, "", false, null);

	
	$airportSubMenu = new SiteMenu();
//	$airportSubMenu->addItem("View flights", SITEURL_FIX_LATER, "", false, null);
	
    $mainMenu = new SiteMenu();
    $mainMenu->addItem(new MenuItem("Home", "index.php"));
	$mainMenu->addItem(new MenuItem("Customers", "customers.php", "", false, $customerSubMenu));
	$mainMenu->addItem(new MenuItem("Employees", "index.php", "", false, $employeeSubMenu));
	$mainMenu->addItem(new MenuItem("Airports", "index.php", "", false, $airportSubMenu));
	$mainMenu->addItem(new MenuItem("Userguide", "index.php"));       
    self::$menu = $mainMenu;
	
	
  }
  
  public static function getPrefix()
  {
    $returnValue = self::$prefix;
    if(substr($returnValue, -1) !== "/")
    {
      $returnValue .= '/';
    }
    return $returnValue;
  }
  
  public static function getPrefixWithoutSlash()
  {
    $returnValue = self::$prefix;
    if(substr($returnValue, -1) === "/")
    {
      $returnValue = substr($returnValue, 0, -1);
    }
    return $returnValue;
  }
  
  public static function getSiteName()
  {
    return "CSIT455 Project";
  }
  
  public static function getTitleSeparator()
  {
    return " | ";
  }
  
  public static function getSiteMenu()
  {
    return self::$menu;
  }
 }
Site::init();
?>