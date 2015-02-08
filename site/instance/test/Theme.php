<?php
class ThemeRender extends Render
{
   function renderSite($title)
   {
      echo 'I am a site <div id="ui-base"> </div>';
   }

   function renderLogin()
   {
      echo "I am the login";
   }

   function renderFields($attributes)
   {
      echo "here are many fields";
   }

   function renderLabels($attributevalues)
   {
      echo "this is nice";
   }

   function renderEndScreen()
   {
      echo "bla bla blaaaa";
   }

   function renderScreen($type, $attributes)
   {
      if ($type === "login")
        $this->renderLogin();
      else if ($type === "edit")
        $this->renderFields($attributes);
      else if ($type === "commit")
        $this->renderLabels($attributes);
      else if ($type === "end")
        $this->renderEndScreen();
      else
        echo "Not a supported type";
   }
   function renderWaitScreen($action)
   {
      echo "Waiting aaaaall day long";
   }
}
?>