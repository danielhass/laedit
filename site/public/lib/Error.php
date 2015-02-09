<?php

class Error
{

   private static $error_stack = array();

   public static function push($msg)
   {
      self::$error_stack[] = $msg;
   }

   public static function flush()
   {
      foreach (self::$error_stack as $msg) {
         echo "--> ".$msg."<br/>";
      }
   }
}
?>