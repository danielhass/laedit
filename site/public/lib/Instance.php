<?php

   function gen_instance_path()
   {
      $instance = settings_instance();
      $instance_path = prefix."/instance/".$instance;
      return $instance_path;
   }

   function instance_valid()
   {
      $instance_path = gen_instance_path();
      if (!$instance_path)
        {
          Error::push("The instance which should be found under :".$instance_path." does not exists");
          return FALSE;
        }
      if (!file_exists($instance_path."/Theme.php"))
        {
          Error::push("The configured instance does not have a Theme.php file!");
          return FALSE;
        }
      return TRUE;
   }

   /*
    * Load the instance which is defined as setting.
    */
   function instance_load()
   {
      $instance_path = gen_instance_path();

      include $instance_path."/Theme.php";
      if (!class_exists("ThemeRender"))
        {
          Error::push("The configured instance does not present a ThemeRender class which should be in Theme.php");
        }
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