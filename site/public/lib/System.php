<?php
/*
 Returns a array with strings which
 are the contents of all the js files
*/
function system_js_get()
{
  return content_get(prefix."/public/js/");
}

/*
 Returns a array with strings which
 are the contents of all the css files
*/
function system_css_get()
{
  return content_get(prefix."/public/css/");
}
?>