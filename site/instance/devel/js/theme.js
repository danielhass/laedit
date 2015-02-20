function theme_login_username_get()
{
   return $("#username").val();
}

function theme_login_password_get()
{
   return $("#password").val();
}

function theme_login_show_error(msg)
{
   alert(msg);
}

function theme_edit_attribute_value_get(key)
{
   var elem;
   if (key.type === "password")
      elem = $(key.name+"_1");
   else
      elem = $(key.name);
   if (!elem)
      alert("Failerhaft");
   else
      return elem.value;
}

function theme_edit_attribute_check(key)
{
   if (key.type === "password")
   {
     var pw1 = $(key.name+"_1");
     var pw2 = $(key.name+"_2");
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