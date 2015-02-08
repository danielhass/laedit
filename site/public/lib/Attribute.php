<?php
class Attribute {
   //internal save array
   private $data;
   // array of internal attributes we are saving
   public static $attributesarray = array("ldapname","displayname","description","widget");

   function __construct($datas, $savetype){
      //init array
      $this ->data = array();
      //copy all avaliable attributes if they are set
      foreach(self::$attributesarray as $name)
      {
         if (isset($datas[$name]))
           $this->data[$name] = $datas[$name];
      }

      //get flags
      $data['savetype'] = $savetype;
   }
   function getLDAPName(){
      return $this ->data['ldapname'];
   }
   function getDisplayName(){
      return $this ->data['displayname'];
   }
   function getWidgetType(){
      return $this->data['widget'];
   }
   function getDescription(){
      return $this ->data['description'];
   }
}

class FilledAttribute
{
   private $attribute;
   private $filled;

   function __construct($attribute, $value)
   {
      $this->attribute = $attribute;
      $this->filled = $value;
   }
   function getValue()
   {
      return $this->filled;
   }
   function getAttribute()
   {
      return $this->attribute;
   }
}

class EditAttribute extends FilledAttribute
{
   private $newval;

   function __construct($attribute, $valueold, $valuenew)
   {
      parent::__construct($attribute, $valueold);
      $this->newval = $valuenew;
   }

   function getNewValue()
   {
      return $this->newval;
   }
}
?>