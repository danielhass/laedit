function theme_login_username_get()
{
   return _$_("username").value;
}

function theme_login_password_get()
{
   return _$_("password").value;
}

function theme_login_show_error(msg)
{
   alert(msg);
}

function theme_edit_attribute_value_get(key)
{
   var elem;
   if (key.type === "password")
      elem = _$_(key.name+"_1");
   else
      elem = _$_(key.name);

   if (!elem){
      alert("Failerhaft");
   }else if(key.type === "checkbox"){
      if(_$_(key.name).checked){
         return 1;
      }else{
         return 0;
      }
    }else{
        return elem.value;
    }
}

function theme_edit_attribute_check(key)
{
   if (key.type === "password")
   {
     var pw1 = _$_(key.name+"_1");
     var pw2 = _$_(key.name+"_2");
     if (!(pw1.value === pw2.value))
       {
          alert("Passwords are not the same");
          return false;
       }
   }
   return true;
}

function theme_waitscreen_title_set(text)
{
  alert("Waiting for "+text);
}