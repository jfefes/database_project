<?php
require_once("Page.inc");
require_once("Menu.inc");
require_once("MenuItem.inc");
require_once("Site.inc");

if(!isset($page))
{
  $page = new Page();
}
$page->addedPHPHeader();
?>
<!DOCTYPE html>
    <head>
        <link rel="stylesheet" href="<?php echo Site::getPrefix(); ?>layout/normalize.css">
        <link rel="stylesheet" href="<?php echo Site::getPrefix(); ?>layout/main.css">
        <link rel="stylesheet" href="<?php echo Site::getPrefix(); ?>layout/site.css">
        <link rel="stylesheet" href="<?php echo Site::getPrefix(); ?>layout/general.css">
        <link rel="stylesheet" href="<?php echo Site::getPrefix(); ?>layout/jquery-ui.min.css">
<?php
  $page->addedHTMLHeader();
?>
    </head>
    <body>
       <div id="main_container">
          <div id="header" class="ui-corner-top">
				<br/>
          </div>
          <div id="left_div">
<?php
  $siteMenu = Site::getSiteMenu();
  $siteMenu->generateMenu("main_menu", "menu", "");
?>
          </div>
          <div id="page_content" class="clearfix contentwrapper">
            <div>&nbsp;</div>
<?php
  $page->pageContent(false);
?>
          </div>
          <div id="footer" class="ui-corner-bottom">
            <p style='text-align: center'>James Fefes, Andrew Morrison, Andrew Hotchkiss, Eugene Nicks<br/>
			SUNY Fredonia CSIT 455, Fall 2013</p>
          </div>
        </div>
        <script src="<?php echo Site::getPrefix(); ?>layout/jquery-1.10.1.min.js"></script>
        <script src="<?php echo Site::getPrefix(); ?>layout/jquery-ui-1.10.1.min.js"></script>
        <script>
          function openWindow( url )
          {
            window.open(url, '_blank');
          }
          $(document).ready(function() {
            $("ul.menu").menu();
            $("a.newtab").click(function() {
              openWindow($(this).attr("href"));
              return false;
            });
          });
        </script>
<?php
  $page->pageEnd();
?>
    </body>
</html>