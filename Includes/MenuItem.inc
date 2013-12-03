<?php
class MenuItem
{
  private $text;
  private $url;
  private $menu;
  private $newTab;
  private $id;
  public function __construct($text, $url = "#", $id = "", $newTab = false,
                              $submenu = null)
  {
    $this->text = $text;
    $this->url = $url;
    $this->menu = $submenu;
    $this->id = $id;
    $this->newTab = $newTab;
  }
  
  public function getText()
  {
    return $this->text;
  }
  
  public function getUrl()
  {
    return $this->url;
  }
  
  public function getSubMenu()
  {
    return $this->menu;
  }
  
  public function getId()
  {
    return $this->id;
  }
  
  public function getOpenNewTab()
  {
    return $this->newTab;
  }
}
?>