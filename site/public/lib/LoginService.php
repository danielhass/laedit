<?php
abstract class LoginService
{
   /*
     passed two strings
     usr = username
     pw = password
     should return true or false
    */
   abstract function login($usr, $pw);
   /*
     attribute is a Attribute instance
     The function should return a FilledAttribute
    */
   abstract function fillAttribute($attribute);

   /*
     attribute is a EditedAttribute instance
     The function should return true or false
     */
   abstract function saveAttribute($attribute);
}

class TestBackend extends LoginService
{
    private $name;
    function login($usr, $pw)
    {
      if ($usr === "nologin")
        return false;
     $this->name = $usr;
      return true;
    }

    function fillAttribute($attribute)
    {
      return new FilledAttribute($attribute, "A sample value");
    }

    function saveAttribute($attribute)
    {
      if ($this->name === "error")
        return false;
      return true;
    }
}
?>