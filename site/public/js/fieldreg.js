var keys = new Array();

function field_register(name,type)
{
   obj = {}
   obj.name = name;
   obj.type = type;
   keys.push(obj);
}

function field_init_fill(){
   for(var element in keys)
   {
      var val = keys[element];
      val.value = theme_edit_attribute_value_get(val);
   }
}

function field_check()
{
   for(var element in keys)
   {
      var val = keys[element];
      if (!theme_edit_attribute_check(val))
        return false;
   }
   return true;
}

function field_fill(obj)
{
   obj.keys = "";
   for(var element in keys)
   {
      var val = keys[element];
      var nval = theme_edit_attribute_value_get(val);
      if (nval != val.value)
        {
           obj[val.name] = nval;
           if (obj.keys === "")
             obj.keys = val.name;
           else
             obj.keys += ","+val.name;
        }
   }
}