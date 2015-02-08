<?php

   function gen_instance_path()
   {
      $instance = settings_instance();
      $instance_path = prefix."/instance/".$instance;
      return $instance_path;
   }

   /*
    * Load the instance which is defined as setting.
    */
   function instance_load()
   {
      $instance_path = gen_instance_path();
      if(!file_exists($instance_path."/Theme.php") ||
         !is_dir($instance_path."/js/")||
         !is_dir($instance_path."/css/"))
      {
         echo "böörked instance ".$instance_path."\n";
         return FALSE;
      }

      include $instance_path."/Theme.php";
      return TRUE;
   }



   /*
     Returns a array with strings which
     are the contents of all the js files
    */
   function instance_js_get()
   {
      $path = gen_instance_path();
      return content_get($path."/js/");
   }

   /*
     Returns a array with strings which
     are the contents of all the css files
    */
   function instance_css_get()
   {
      $path = gen_instance_path();
      return content_get($path."/css/");
   }
?>