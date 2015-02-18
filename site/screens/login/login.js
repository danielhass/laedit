var username;
var password;

function _login_process()
{
   var usr = theme_login_username_get();
   var pw = theme_login_password_get();
   if (usr === "" || pw === "")
    {
       theme_login_show_error("No empty fields!!");
       return;
    }
   obj = new Array();
   obj.username = username =  usr;
   obj.password = password = pw;
   return obj;
}

workflow_register("login", _login_process);