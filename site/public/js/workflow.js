var state;
var username;
var password;
var changed;
var workflows = ['login', 'edit', 'commit', 'end'];

function workflow_init() {
   state = 0;
}

function _workflow_login_step()
{
   var usr = theme_login_username_get();
   var pw = theme_login_password_get();
   if (usr === "" || pw === "")
    {
       theme_login_show_error("No empty fields!!");
       return;
    }
   obj = new Array();
   obj.username = usr;
   obj.password = pw;
   ui_display_screen("edit", obj,
   function(obj){
      theme_login_show_error(obj.answer);
   },
   function(obj){
      username = usr;
      password = pw;
      field_init_fill();
      state ++;
   });
}

function _workflow_edit_screen()
{
   if (!field_check())
     {
        alert("Field check failed");
        return;
     }
   obj = new Array();
   obj.username = username;
   obj.password = password;
   field_fill(obj);
   ui_display_screen("commit", obj,
   function(obj){
      alert("BA BA BAAAAAAA.");
   },
   function(obj2){
      changed = obj;
      state ++;
   })
}

function _workflow_commit_screen()
{
   ui_display_screen("endscreen", changed,
   function(obj){
      alert("BA BA BAAAAAAA.");
   },
   function(obj2){
      changed = obj;
      state ++;
   })
}

function workflow_continue() {
   switch(state)
   {
      case 0:
         _workflow_login_step();
      break;
      case 1:
         _workflow_edit_screen();
      break;

      case 2:
         _workflow_commit_screen();
      break;
   }
}

function workflow_end() {
   window.location.reload();
}