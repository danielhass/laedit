<?php
function screen_init()
{
   $screens = array();
   $pref = prefix."/screens/";
   $handle = opendir(prefix."/screens/");
   if (!$handle)
     {
        Error::push("Failed to open screens directory!!");
        return FALSE;
     }
   while(($dir = readdir($handle)) !== false)
     {
        // we dont want those dirs
        if ($dir === "." || $dir === "..") continue;
        if (!is_dir($pref . $dir)) continue; //FIXME should we put up a error here ?

        $php_file = $pref.$dir."/".$dir.".php";

        if (!file_exists($php_file))
          {
             Error::push("Error php file of screen ".$dir." does not exist");
             return FALSE;
          }
        include $php_file;

        $js_file = $pref.$dir."/".$dir.".js";
        if (!file_exists($php_file))
          {
             Error::push("Error js file of screen ".$dir." does not exist");
             return FALSE;
          }

        $screens[$dir] = array();
        $screens[$dir]["js"] = file_get_contents($js_file);
        $screens[$dir]["path"] = $pref.$dir;
     }
   Instance::push("screens", $screens);
   return TRUE;
}

function screen_js_get()
{
   $screens = Instance::get("screens");
   $result = array();
   foreach ($screens as $screen) {
      $result[] = $screen["js"];
   }
   return $result;
}

function screen_create_instance($name)
{
   $screens = Instance::get("screens");
   if (isset($screens[$name]))
     return new $name();
   Error::push("Screen ".$name." not found.");
   return NULL;
}

abstract class Screen {
   //render the screen.
   abstract function render();
   //process the rendered screen and setup things you can.
   abstract function process();
}
?>