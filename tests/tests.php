<?php

function out($text)
{
   echo "====> ".$text."\n";
}

define("config_file","./settings.test");
define("template_file", "./template.xml");
define("prefix", "../site/");

include "../site/public/lib/Utils.php";
include "../site/public/lib/Settings.php";
include "../site/public/lib/Instance.php";
include "../site/public/lib/Render.php";
include "../site/public/lib/Template.php";
include "../site/public/lib/Attribute.php";

out("Testing Settings");
if (!settings_testFile())
{
   out("Test failed.");
   exit(-1);
}
out("Test done.");

out("Testing Instance");

instance_load();

out("Test done.");

out("Testing test Instance");

$render = new ThemeRender();
$render->renderSite("What a wunderfull site");
echo "\n";
$render->renderLogin();
echo "\n";
$render->renderFields(NULL);
echo "\n";
$render->renderLabels(NULL);
echo "\n";
$render->renderEndScreen();
echo "\n";
$render->renderWaitScreen("Waiting forever");
echo "\n";
out("Test done.");

out("Testing test Instance js files");
$arr = instance_js_get();
var_dump($arr);
out("Test done.");

out("Testing test Instance css files");
$arr = instance_css_get();
var_dump($arr);
out("Test done.");

out("Testing test Template");
$arr = new Template();
foreach ($arr->attributes as $value) {
   if($value->getLDAPName() === "b" &&
      $value->getDisplayName() === "b" &&
      $value->getDescription() === "b")
      continue;
   else
   {
      out("BAAAD wrong value");
      out("FAILERHAFT");
      return -1;
   }
}
out("Test done.");

out("Done.\n");
?>