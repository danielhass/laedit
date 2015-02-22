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
            <a class="navbar-brand" href="#">l&#x00E6;dit</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
              <li class="active"><a href="#">Editor</a></li>
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
          <input type="text" id="username" class="form-control input-sm chat-input login-elem" placeholder="Username" autofocus="true" onkeydown="if (event.keyCode == 13) clickLoginBtn()"/>
          <input type="password" id="password" class="form-control input-sm chat-input login-elem" placeholder="Password" onkeydown="if (event.keyCode == 13) clickLoginBtn()"/>
	  <button type="button" id="loginbtn" class="btn btn-primary login-btn" onClick="workflow_continue();"> Login </button>
          <div class="wel-msg"> Welcome to l&#x00E6;dit, please log in. </div>
          </div>
       </div>

EOF;
      return $result;
   }

   function renderFields($attributes)
   {
      $result = <<<EOF

       <div class="col-md-offset-3 col-md-5">
       <div class="alert alert-warning" role="alert">You're now in editing mode.</div>

EOF;
      foreach ($attributes as $value) {
        $attr = $value->getAttribute();
        $result .=  '<div class="attr-body"> <div class="attr-header"> '.$attr->getDisplayName().':</div>';
        if ($attr->getWidgetType() === "password")
        {
          $result .=  '<input id="'.$attr->getLDAPName().'_1" class="form-control input-sm chat-input editor-input" type="password" size="25" value="'.password_placeholder.'"/><br/>';
          $result .=  '<input id="'.$attr->getLDAPName().'_2" class="form-control input-sm chat-input editor-input" type="password" size="25" value="'.password_placeholder.'"/>';
        }
        else if ($attr->getWidgetType() === "label")
        {
          $result .=  '<input id="'.$attr->getLDAPName().'" class="form-control input-sm chat-input" type="label" readonly="true" size="25" value="'.$value->getValue().'"/>';
        }
        else if ($attr->getWidgetType() === "text")
        {
          $result .=  '<input id="'.$attr->getLDAPName().'" class="form-control input-sm chat-input editor-input" type="text" size="25" value="'.$value->getValue().'"/>';
        }
        else if ($attr->getWidgetType() === "checkbox")
        {
          $result .=  '<input id="'.$attr->getLDAPName().'" class="editor-checkbox" type="checkbox"/>';
        }
        $result .=  '</div>';
      }
      $result .=  "<br/><button type=\"button\" class=\"btn btn-primary login-btn\" onClick=\"workflow_continue();\">Commit changes</button>";

      $result .= <<<EOF

       </div>

EOF;

      return $result;
   }

   function renderLabels($attributevalues)
   {
      $result = <<<EOF

       <div class="col-md-offset-3 col-md-5">
       <div class="panel panel-info">
          <div class="panel-heading">Commit Screen</div>
          <div class="panel-body">
             <p>This is the commit screen. Here can you check the changed values before they are saved to the server.</p>
          </div>

EOF;

      if ($attributevalues == NULL)
        $result .=  "<div class=\"alert alert-danger\" role=\"alert\"><b>No changes made.</b></div>";
      else{
        $result .= "<table class=\"table\">";
        $result .= <<<EOF
        <thead>
           <tr>
              <th data-field="val_old">Old Value</th>
              <th data-field="val_new">New Value</th>
           </tr>
        </thead>
        <tbody>\n
EOF;
        foreach ($attributevalues as $value) {
            $result .= "<tr>";
            $result .=  "<td>".$value->getValue()."</td>";
            $result .=  "<td>".$value->getNewValue()."</td>";
            $result .= "</tr>";    
        }
        $result .= "</tbody>";
        $result .= "</table>";
       }
      $result .=  "</div>";
      $result .=  "<br/><button type=\"button\" class=\"btn btn-primary login-btn\" onClick=\"workflow_continue();\">Save</button>";
      $result .=  "</div>";
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