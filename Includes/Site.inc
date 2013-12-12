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
  private static $prefix = "/trunk";
  private static $menu;
  static function init(){
      
	$customerSubMenu = new SiteMenu();
	$customerSubMenu->addItem( new MenuItem("New customer", Site::getPrefixWithoutSlash() . "/customer/new_cust.php", "", false));
	$customerSubMenu->addItem( new MenuItem("Reserve flight", Site::getPrefixWithoutSlash() . "/customer/reserve.php", "", false));
		
	$employeeSubMenu = new SiteMenu();
	$employeeSubMenu->addItem( new MenuItem("Add new employee", Site::getPrefixWithoutSlash() . "/employees/add_employee.php", "", false));


	$examplesSubMenu = new SiteMenu();
	$examplesSubMenu->addItem( new MenuItem("Ex. 1", Site::getPrefixWithoutSlash() . "/examples/serv_test.php", "", false));
	$examplesSubMenu->addItem( new MenuItem("Ex. 2", Site::getPrefixWithoutSlash() . "/examples/serv_test2.php", "", false));
	
	
	$airportSubMenu = new SiteMenu();
	$airportSubMenu->addItem( new MenuItem("Add new airport", Site::getPrefixWithoutSlash() . "/airports/add_airport.php", "", false));
	$airportSubMenu->addItem( new MenuItem("View airport", Site::getPrefixWithoutSlash() . "/airports/view_airport.php", "", false));

	
    $mainMenu = new SiteMenu();
    $mainMenu->addItem(new MenuItem("Home", Site::getPrefix() . "index.php"));
	$mainMenu->addItem(new MenuItem("Customers", Site::getPrefixWithoutSlash() . "/customer/index.php", "", false, $customerSubMenu));
	$mainMenu->addItem(new MenuItem("Airports", Site::getPrefixWithoutSlash() . "/airports/index.php", "", false, $airportSubMenu));
	$mainMenu->addItem(new MenuItem("Employees", Site::getPrefixWithoutSlash() . "/employees/index.php", "", false, $employeeSubMenu));
	//$mainMenu->addItem(new MenuItem("Userguide", Site::getPrefix() . "index.php"));       
	//$mainMenu->addItem(new MenuItem("Examples", Site::getPrefix() . "serv_test.php", "", false, $examplesSubMenu));;       
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