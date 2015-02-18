<?php
class Login extends Screen {
   function render()
   {
      $render = Instance::get("render");
      //wow what kind of work :|
      return $render->renderScreen("login", NULL);
   }

   function process()
   {
      $auth = Instance::get("auth");
      //does everything ...
      login($auth);
   }
}
?>