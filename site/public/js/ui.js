function $(val)
{
   return document.getElementById(val);
}

function set_base(newval)
{
   var base = $("ui-base");
   if(!base) alert("You theme is not valid");
   base.innerHTML = newval;
}

function ui_verify_theme(){
   if(typeof theme_login_username_get !== 'undefined' &&
      typeof theme_login_password_get !== 'undefined' &&
      typeof theme_login_show_error !== 'undefined' &&
      typeof theme_edit_attribute_value_get !== 'undefined' &&
      typeof theme_edit_attribute_check !== 'undefined' &&
      typeof theme_waitscreen_title_set !== 'undefined')
      return true;
   else
      return null;
}

function ui_loaded()
{
   var ws = $("waitscreen")
   if(!ws) return false;

   set_base(ws.innerHTML);
   return true;
}

function ui_display_screen(screen, obj, error, positive)
{
   request_screen(screen, function(obj){
      if (obj.exitcode < 0 && error)
      {
        error(obj);
      }
      else
      {
        set_base(obj.answer);
        if (positive)
          positive();
      }
   }, obj);
}