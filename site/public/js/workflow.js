var register = {};
var backband;
var lastscreen;

function workflow_register(name, functionnn)
{
  register[name] = {};
  register[name]["function"] = functionnn;
}
//valid are created and error
function workflow_register_signal(name, signal, functionnn)
{
    register[name][signal] = functionnn;
}

function workflow_signal_call(signal, name)
{
  if (register[name][signal])
    return register[name][signal]();
}

function workflow_call(name)
{
  return workflow_signal_call("function", name);
}

function workflow_last_screen_set(name)
{
  lastscreen = name;
}

function workflow_band_set(band)
{
  backband = band;
}

function workflow_last_screen_get()
{
  return lastname;
}

function workflow_startup()
{
  var init = {};
  init.plain_init = "YES";
  ui_display_request(init,
  function(obj){
    alert("init failed ... last msg: "+obj.answer);
  },
  function(obj){
    workflow_last_screen_set(obj.screen);
  });
}

function workflow_continue(sign) {
  obj = workflow_call(lastscreen);
  if (!obj)
    obj = {};
  //we are going a shortcut here ...
  obj.username = username;
  obj.password = password;
  obj.band = backband;
  obj.key = sign;
  ui_display_request(obj,
  function(ans){
    alert(ans.answer);
  },
  function(ans){
    workflow_last_screen_set(ans.screen);
    workflow_signal_call("created", ans.screen)
    workflow_band_set(ans.band);
  });
}

function workflow_end() {
   window.location.reload();
}