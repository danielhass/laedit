var editObject;

function _workflow_edit_screen()
{
   if (!field_check())
     {
        alert("Field check failed");
        return;
     }
   obj = new Array();
   field_fill(obj);
   editObject = obj;
   return obj;
}

function _workflow_edit_screen_created()
{
   field_init_fill();
}

workflow_register("edit", _workflow_edit_screen);
workflow_register_signal("edit", "created" ,_workflow_edit_screen_created);