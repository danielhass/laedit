<?php

function createAnswer($exitcode,$answer = null, $log = null){

   header('Content-type: text/xml');
   echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
   echo "<request>\n";
   echo "<exitcode>".$exitcode."</exitcode>\n";
   echo "<log>".$log."</log>";
   echo "<answer>\n";
   //echo "<![CDATA[";
   echo $answer;
   //echo "]]>";
   echo"</answer>\n";
   echo "</request>\n";
   //end and flush the buffer !
   ob_end_flush();
   exit();
}

function login($auth)
{
   if (!isset($_POST['username']) || !isset($_POST['password']))
     createAnswer(-1, "No login params ... BAD");

   if (!$auth->login($_POST['username'], $_POST['password']))
     createAnswer(-1, "Login failed");
}

function proceed_edit($auth,$render)
{
   login($auth);
   $template = new Template();
   $filled = array();
   foreach ($template->attributes as $attr) {
      $filled[] = $auth->fillAttribute($attr);
   }

   return $render->renderScreen("edit", $filled);
}

function parse_editattribute($auth)
{
   $template = new Template();

   $keys_ = $_POST['keys'];
   $keys = explode(",", $keys_);
   $newvalues = array();
   foreach ($keys as $key) {
      $val = $_POST[$key];
      $newvalues[$key] = $val;
   }
   $newones = array();
   foreach ($template->attributes as $attr) {
      foreach ($newvalues as $key => $value) {
         if ($key !==  $attr->getLDAPName()) continue;

         $filled = $auth->fillAttribute($attr);
         $newones[] = new EditAttribute($attr, $filled->getValue(), $value);
      }
   }
   return $newones;
}

function proceed_commit($auth, $render)
{
   login($auth);

   $keys_ = $_POST['keys'];

   if ($keys_ === "")
     return $render->renderScreen("commit", NULL);

   $newones = parse_editattribute($auth);

   return $render->renderScreen("commit", $newones);
}

function proceed_safe($auth, $render)
{
   $newones = parse_editattribute($auth);

   $keys_ = $_POST['keys'];

   if ($keys_ === "")
     return $render->renderScreen("end", NULL);

   foreach ($newones as $value) {
      if (!$auth->saveAttribute($value))
        createAnswer(-1, "Saving files failed while sending, ask a admin!");
   }
   return $render->renderScreen("end", NULL);
}

include "./lib/Main.php";
include "./lib/Utils.php";
include "./lib/Attribute.php";
include "./lib/LoginService.php";
include "./lib/Render.php";
include "./lib/Instance.php";
include "./lib/Settings.php";
include "./lib/System.php";
include "./lib/Template.php";


//check if settings are working
if (!settings_testFile())
  error("Error failed to load settings!!", FALSE);

//check if instance is valid
if (!instance_valid())
  error("Error configured instance is not valid", FALSE);

//check if we can load instance
if (!instance_load())
  error("Error failed to load instance", FALSE);

//check if the configured template is cool
if (!template_valid())
  error("Error failed to load template file", FALSE);

ob_start();

//create instance of the render
$render = new ThemeRender();

$service = settings_loginservice();
$auth = new $service();

$output = "";

switch($_POST['screen']){
   case "login":
      $output = $render->renderScreen("login", NULL);
   break;
   case "edit":
      $output = proceed_edit($auth, $render);
   break;
   case "commit":
      $output = proceed_commit($auth, $render);
   break;
   case "endscreen":
      $output = proceed_safe($auth,$render);
   break;
}

$log = ob_get_contents();
ob_end_clean();

createAnswer(1, $output, $log);
?>