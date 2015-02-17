<?php
class ThemeRender extends Render
{
   function renderSite($title)
   {
      //return 'I am a site <div id="ui-base"> </div>';
	return '
      <!-- Static navbar -->
      <nav class="navbar navbar-default">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">laedit</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Home</a></li>
            </ul>
          </div><!--/.nav-collapse -->
        </div><!--/.container-fluid -->
      </nav>
      <div id="ui-base"></div>
               ';
   }


   function renderLogin()
   {
      $result = <<<EOF

       <div class="col-md-offset-4 col-md-3">
	  <div class="login-form">
          <h4>Login:</h4>
          <input type="text" id="username" class="form-control input-sm chat-input login-elem" placeholder="Username" />
          <input type="password" id="password" class="form-control input-sm chat-input login-elem" placeholder="Password" />
	     <button type="button" class="btn btn-primary login-btn" onClick="workflow_continue();">Login</button>
          </div>
       </div>

EOF;
      return $result;
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