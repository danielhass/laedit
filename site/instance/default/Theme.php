<?php
class ThemeRender extends Render
{
   function renderSite($title)
   {
      return 'I am a site <div id="ui-base"> </div>';
   }

   function renderLogin()
   {
      return "<form onSubmit=\"workflow_continue(); return false;\" action='login.php' method='post' accept-charset='UTF-8'>
            <fieldset >
            <legend>Login</legend>

            <label for='username' >UserName*:</label>
            <input type='text' name='username' id='username'  maxlength=\"50\" /><br/>

            <label for='password' >Password*:</label>
            <input type='password' name='password' id='password' maxlength=\"50\" /><br/>

            <input type='submit' name='Submit' value='Login' />

            </fieldset>
            </form>";
   }

   function renderFields($attributes)
   {
      $result = "";
      foreach ($attributes as $value) {
        $attr = $value->getAttribute();
        $result .= '<h3>'.$attr->getDisplayName().':</h3>';
        if ($attr->getWidgetType() === "password")
        {
          $result .=  '<input id="'.$attr->getLDAPName().'_1" type="password" size="25" value="'.password_placeholder.'"/><br/>';
          $result .=  '<input id="'.$attr->getLDAPName().'_2" type="password" size="25" value="'.password_placeholder.'"/>';
        }
        else if ($attr->getWidgetType() === "label")
          $result .=  '<input id="'.$attr->getLDAPName().'" type="label" readonly="true" size="25" value="'.$value->getValue().'"/>';
        else if ($attr->getWidgetType() === "text")
          $result .=  '<input id="'.$attr->getLDAPName().'" type="text" size="25" value="'.$value->getValue().'"/>';
      }
      $result .=  "<br/><button onclick=\"workflow_continue();\"> Commit </button>";
      return $result;
   }

   function renderLabels($attributevalues)
   {
      $result = "";
      if ($attributevalues == NULL)
        $result .=  "No changes<br/>";
      else
        foreach ($attributevalues as $value) {
          $result .=  "Value change from ".$value->getValue()." To ".$value->getNewValue(). "<br/>";
        }
      $result .=  "<button onclick=\"workflow_continue();\"> Safe </button>";
      return $result;
   }

   function renderEndScreen()
   {
      $result = "";
      $result .= "Everything is finished!! reloading ?<br/>";
      $result .= "<button onclick=\"workflow_end();\"> Yes </button>";
      return $result;
   }

   function renderScreen($type, $attributes)
   {
      if ($type === "login")
        return $this->renderLogin();
      else if ($type === "edit")
        return $this->renderFields($attributes);
      else if ($type === "commit")
        return $this->renderLabels($attributes);
      else if ($type === "end")
        return $this->renderEndScreen();
      else
        return "Not a supported type";
   }
   function renderWaitScreen($action)
   {
      return "Waiting aaaaall day long";
   }
}
?>