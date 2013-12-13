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
	$customerSubMenu->addItem( new MenuItem("Search customers", Site::getPrefixWithoutSlash() . "/customer/search_cust.php", "", true));
	$customerSubMenu->addItem( new MenuItem("Add new customer", Site::getPrefixWithoutSlash() . "/customer/add_cust.php", "", false));
	$customerSubMenu->addItem( new MenuItem("Remove customer", Site::getPrefixWithoutSlash() . "/customer/rem_cust.php", "", false));
	$customerSubMenu->addItem( new MenuItem("Assign a flight", Site::getPrefixWithoutSlash() . "/customer/assign_cust.php", "", false));
		
	$employeeSubMenu = new SiteMenu();
	$employeeSubMenu->addItem( new MenuItem("Search employees", Site::getPrefixWithoutSlash() . "/employees/search_employee.php", "", true));
	$employeeSubMenu->addItem( new MenuItem("Add new employee", Site::getPrefixWithoutSlash() . "/employees/add_employee.php", "", false));
	$employeeSubMenu->addItem( new MenuItem("Remove employee", Site::getPrefixWithoutSlash() . "/employees/rem_employee.php", "", false));
	$employeeSubMenu->addItem( new MenuItem("Assign a job", Site::getPrefixWithoutSlash() . "/employees/assign_employee.php", "", false));
	
	$airportSubMenu = new SiteMenu();
	$airportSubMenu->addItem( new MenuItem("Search airports", Site::getPrefixWithoutSlash() . "/airports/search_airport.php", "", true));
	$airportSubMenu->addItem( new MenuItem("Add new airport", Site::getPrefixWithoutSlash() . "/airports/add_airport.php", "", false));
	$airportSubMenu->addItem( new MenuItem("Remove airport", Site::getPrefixWithoutSlash() . "/airports/rem_airport.php", "", false));

	$flightsSubMenu = new SiteMenu();
	$flightsSubMenu->addItem( new MenuItem("Search flights", Site::getPrefixWithoutSlash() . "/flights/search_flight.php", "", true));
	$flightsSubMenu->addItem( new MenuItem("Add flight", Site::getPrefixWithoutSlash() . "/flights/add_flight.php", "", false));
	$flightsSubMenu->addItem( new MenuItem("Remove flight", Site::getPrefixWithoutSlash() . "/flights/rem_flight.php", "", false));
	$flightsSubMenu->addItem( new MenuItem("Take-off/Land flight", Site::getPrefixWithoutSlash() . "/flights/control_flight.php", "", false));
	
	
    $mainMenu = new SiteMenu();
    $mainMenu->addItem(new MenuItem("Home", Site::getPrefix() . "index.php"));
	$mainMenu->addItem(new MenuItem("Customers", Site::getPrefixWithoutSlash() . "/customer/index.php", "", false, $customerSubMenu));
	$mainMenu->addItem(new MenuItem("Airports", Site::getPrefixWithoutSlash() . "/airports/index.php", "", false, $airportSubMenu));
	$mainMenu->addItem(new MenuItem("Employees", Site::getPrefixWithoutSlash() . "/employees/index.php", "", false, $employeeSubMenu));
	$mainMenu->addItem(new MenuItem("Flights", Site::getPrefixWithoutSlash() . "/flights/index.php", "", false, $flightsSubMenu));
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