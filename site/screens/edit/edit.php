<?php
class Edit extends Screen
{
   function render()
   {
      $auth = Instance::get("auth");
      $render = Instance::get("render");

      login($auth);

      $template = new Template();
      $filled = array();
      foreach ($template->attributes as $attr) {
         $filled[] = $auth->fillAttribute($attr);
      }

      return $render->renderScreen("edit", $filled);
   }

   function process()
   {

   }
}
?>