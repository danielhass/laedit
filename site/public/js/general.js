var parseXml;
function loaded(){
   if (!ui_loaded())
   {
      alert("No waitscreen - PANIC");
      return;
   }

   xml_init();
   if (!parseXml)
   {
      alert("XML parser not found");
      return;
   }

   if (!ui_verify_theme())
   {
      alert("Theme not valid!");
      return;
   }
   workflow_init();
   ui_display_screen("login");
}

function xml_init(){
   if (typeof window.DOMParser != "undefined") {
       parseXml = function(xmlStr) {
           return ( new window.DOMParser() ).parseFromString(xmlStr, "text/xml");
       };
   } else if (typeof window.ActiveXObject != "undefined" &&
          new window.ActiveXObject("Microsoft.XMLDOM")) {
       parseXml = function(xmlStr) {
           var xmlDoc = new window.ActiveXObject("Microsoft.XMLDOM");
           xmlDoc.async = "false";
           xmlDoc.loadXML(xmlStr);
           return xmlDoc;
       };
   } else {
       throw new Error("No XML parser found");
   }
}