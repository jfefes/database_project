<?php
abstract class Menu
{
  private $items;
  
  public function __construct()
  {
    $this->items = array();
  }
  
  public function addItem($item)
  {
    $this->items[] = $item;
  }
  
  public function getItems()
  {
    return $this->items;
  }
  
  abstract public function generateMenu($elementId = "", $elementClass = "", $itemClass = "");
}
?>