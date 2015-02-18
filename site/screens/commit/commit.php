<?php

class commit extends Screen
{
   private function parse_editattribute($auth)
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
   public function render()
   {
      $auth = Instance::get("auth");
      $render = Instance::get("render");

      login($auth);

      $keys_ = $_POST['keys'];

      if ($keys_ === "")
        return $render->renderScreen("commit", NULL);

      $newones = $this->parse_editattribute($auth);

      return $render->renderScreen("commit", $newones);
   }

   public function process()
   {
      $auth = Instance::get("auth");
      $render = Instance::get("render");

      $newones = $this->parse_editattribute($auth);

      $keys_ = $_POST['keys'];

      foreach ($newones as $value) {
         if (!$auth->saveAttribute($value))
           createAnswer(-1, "Saving files failed while sending, ask a admin!");
      }
   }
}
?>