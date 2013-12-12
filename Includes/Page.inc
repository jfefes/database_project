<?php
class Page
{
  private $title;
  
  
  public function __construct()
  {
    $this->title = "";
	
  }
  
  // This function would be called after the session has been started
  public function addedPHPHeader()
  {
  }
  
  public function addedHTMLHeader()
  {
  }
  
  public function getTitle()
  {
    return $this->title;
  }
  
  protected function setTitle($title)
  {
    $this->title = $title;
  }
 
  public function pageContent($printerFriendly)
  {
  }
  
  public function pageEnd()
  {
  }

}
?>