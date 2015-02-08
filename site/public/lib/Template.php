<?php
/*
 Template parser
 */
class Template
{
   //array of attributes
   public $attributes = array();

   public function __construct ()
   {
      //open and read the template file
      $content = file_get_contents(template_file);
      //parse the read content
      $this->parse($content);
   }
   private function parseChild($child)
   {
      //data is a array with tag names as keys and nodevalues as value
      $data = array();
      //check if we have a savetype
      $savetype = $child->attributes->getNamedItem("savetype");
      if ($savetype)
        $st = $savetype->value;
      else
        $st = NULL;

      foreach($child->childNodes as $it)
      {
         $val = $it->nodeName;
         //check if values are valid
         if ($val === "description"||
              $val === "ldapname" ||
              $val === "widget" ||
              $val === "displayname")
         {
            //tmp save them
            $data[$val] = $it->nodeValue;
         }
      }
      //create the new attribute
      $this->attributes[] = new Attribute($data, $st);
   }
   private function parse($file)
   {
      //create xml parser
      $xml = new DOMDocument();
      //parse the xml
      $xml->loadXML($file);
      //search for the attributes
      $list = $xml->getElementsByTagName("attribute");
      //parse each child
      foreach($list as $item)
      {
         $this->parseChild($item);
      }
   }
}

?>