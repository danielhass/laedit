function parse(xml, obj, val)
{
   var list = xml.getElementsByTagName(val)

   if (list.length == 0) return;
   obj[val] = list[0].innerHTML;
}

function xmlToObject(xml)
{
   var obj = {};
   parse(xml, obj, "answer");
   parse(xml, obj, "exitcode");
   parse(xml, obj, "screen");
   parse(xml, obj, "band");
   return obj;
}

function request_screen(func, obj)
{
   var params = "";
   for(var key in obj)
   {
      if (params != "")
        params += "&";
      params += key+"="+obj[key];
   }
   if (window.XMLHttpRequest) {
      req = new XMLHttpRequest();
   } else {
      //FIXME drop suppert for I6&5 ?
      req =  new ActiveXObject("Microsoft.XMLHTTP");
   }
   req.onreadystatechange = function() {
      if(req.readyState == 4) {
         var result = req.responseText;
         var xml = parseXml(result);
         func(xmlToObject(xml));
      }
   }
   req.open("POST", "backindex.php", true);
   req.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   req.setRequestHeader("Content-length", params.length);
   req.setRequestHeader("Connection", "close");
   req.send(params);
}