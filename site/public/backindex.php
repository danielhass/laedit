<?php
include "./lib/Main.php";
include "./lib/Utils.php";
include "./lib/Attribute.php";
include "./lib/LoginService.php";
include "./lib/Render.php";
include "./lib/Error.php";
include "./lib/Instance.php";
include "./lib/Settings.php";
include "./lib/System.php";
include "./lib/Template.php";
include "./lib/Screens.php";
include "./lib/Workflowcontrol.php";

ob_start();

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

//check if screen_config is valid
if (!screen_config_valid())
  error("Error screen config not valid", FALSE);

//load screen_config
if (!screen_config_load())
  error("Error screen config could not be loaded", FALSE);

if (!screen_init())
  error("Error screen init failed!", FALSE);

//create instance of the render
$render = new ThemeRender();
Instance::push("render", $render);

$service = settings_loginservice();
$auth = new $service();
Instance::push("auth", $auth);

/* init state maschine */
$maschine = Instance::get("screen_config");

$lastscreen = NULL;
$newscreen = NULL;

if (!isset($_POST['plain_init']) && isset($_POST['band']) && isset($_POST['key']))
  {
    //we are in a workflow
    $arr = explode(",", $_POST['band']);
    $maschine->setBand($arr);
    //get the past screen to proceed things
    $lastscreen = $maschine->getScreen();
    //pass the new symbol
    $val = $_POST['key'];
    $maschine->enterSymbol($val);
    //get the new screen
    $newscreen = $maschine->getScreen();
  }
else if ((isset($_POST['plain_init'])))
  {
    //we are in the case that we are at the startup, render login screen!
    $lastscreen = NULL;
    $newscreen = "login";
  }
else if (!isset($_POST['plain_init']) && !isset($_POST['band']) && !isset($_POST['key']))
  {
    //we are in the case that the login screen is the last screen which got rendered.
    $lastscreen = "login";
    $newscreen = $maschine->getScreen();
  }
else
  {
    //something is basically fucked. :)
    createAnswer(-1, "Error band AND key var must be present!!");
  }

$output = "last: ".$lastscreen." new: ".$newscreen;

if ($lastscreen)
  {
     $ls_instance = screen_create_instance($lastscreen);
     if (!$ls_instance)
       createAnswer(-1, "Screen instance ".$lastscreen." not found");
     $ls_instance->process();
  }

if (!$newscreen)
  {
     $log = ob_get_contents();
     ob_end_clean();

     createAnswer(-1, "no newscreen :( what should I do ?", $log);
  }

$ns_instance = screen_create_instance($newscreen);
if (!$ns_instance)
  createAnswer(-1, "Screen instance ".$newscreen." not found");

$log = ob_get_contents();
ob_end_clean();

$band = "";
foreach ($maschine->getBand() as $part) {
  if ($band === "")
    $band = $part;
  else
    $band .= ",".$part;
}

createAnswer(1, $ns_instance->render(), $log, $newscreen, $band);

/*
$output = "";

switch($_POST['screen']){
   case "login":
      $output = $render->renderScreen("login", NULL);
   break;
   case "edit":
      $output = proceed_edit();
   break;
   case "commit":
      $output = proceed_commit();
   break;
   case "endscreen":
      $output = proceed_safe();
   break;
}

$log = ob_get_contents();
ob_end_clean();

createAnswer(1, $output, $log);*/
?>