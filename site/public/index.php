<?php

include "./lib/Main.php";
include "./lib/Error.php";
include "./lib/Utils.php";
include "./lib/Render.php";
include "./lib/Instance.php";
include "./lib/Settings.php";
include "./lib/System.php";
include "./lib/Attribute.php";
include "./lib/Template.php";
include "./lib/Screens.php";
include "./lib/Workflowcontrol.php";

function formheader($titlesite)
{
   echo "<head>";
   echo '<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">';
   echo '<style type="text/css">';
   //write down all the css things from the instance
   output_array(instance_css_get());
   output_array(system_css_get());
   echo '</style>';
   echo '<script language="javascript">';
   //write down all the css things from the instance
   output_array(instance_js_get());
   output_array(system_js_get());
   output_array(screen_js_get());
   echo '</script>';
   echo "</head>";
}


//we are cool, we are sending a _real_ header
echo "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\">";
echo "<html>";
//check if settings are working
if (!settings_testFile())
  error("Error failed to load settings!!");

//check if instance is valid
if (!instance_valid())
  error("Error configured instance is not valid");

//check if we can load instance
if (!instance_load())
  error("Error failed to load instance");

//check if the configured template is cool
if (!template_valid())
  error("Error failed to load template file");

//check if screen_config is valid
if (!screen_config_valid())
  error("Error screen config not valid");

//load screen_config
if (!screen_config_load())
  error("Error screen config could not be loaded");

if (!screen_init())
  error("Error screen init failed!");

//create instance of the render
$render = new ThemeRender();
$template = new Template();

formheader("Hello I am the title");
//render ground site
echo "<body>";
echo '<div class="illuminati" style="visibulity:hidden;position: absolut;"/></div>';
echo $render->renderSite("Hello I am the title");
//render a waitscreen which can be shown
echo '<div id="waitscreen" class="hidden">';
echo $render->renderWaitScreen("Waiting for content");
echo '</div>';
//call the script that we are loaded
echo '<script language="javascript">';
echo 'loaded();';
foreach ($template->attributes as $value) {
  $val = $value->getLDAPName();
  $type = $value->getWidgetType();
  echo 'field_register("'.$val.'","'.$type.'");';
}
echo '</script>';
echo "</body>";

echo "</html>";
?>