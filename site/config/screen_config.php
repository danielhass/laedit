<?php

class Maschine extends StateMaschine
{
   private $oldstate = 0;

   private $states = array("login", "edit", "commit", "end");

   public function __construct(){
      $this->oldstate = 0;
   }
   public function setBand($arr)
   {
      $val = intval($arr[0]);
      $this->oldstate = $val;
   }

   public function enterSymbol($s)
   {
      if ($this->oldstate < 2)
        $this->oldstate += 1;
      else
        $this->oldstate = 1;
   }

   public function getScreen()
   {
      return $this->states[$this->oldstate];
   }

   public function getBand()
   {
      $result = array();
      $result[] = ""+$this->oldstate;
      return $result;
   }
   public function panic()
   {
      $this->oldstate = 0;
   }
}

?>