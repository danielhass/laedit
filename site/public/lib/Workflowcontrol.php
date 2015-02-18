<?php
/*
 This State Maschine works like this.

 After creating the class, setBand is called where a
 array of Strings is passed. If it is the init case this will not happen

 The first getScreen call should return the last screens name, so the config page can fullfill the pending request.
 This is NOT called in the init case.

 After that enterSymbol is called, the passed symbol is the
 charsequenz which got passed to workflow_continue. Will not happen in the init case.

 getScreen should return the string of the screen to use NOW.

 then getBand is called, the result of this call will be again
 passed to the setBand method in the next call

 If it is the plain startup just getBand will be called
 after the creation.

 */

abstract class StateMaschine {

   /*
    * Called to pass a Band to the state maschine
    */
   public abstract function setBand($arr);
   /*
    * Gives the symbol which was passed to the workflow
    */
   public abstract function enterSymbol($s);
   /*
    * Return the name of the screen to render now or to fullfill the pending command
    */
   public abstract function getScreen();
   /*
    * Should return a array of strings,
    * will be passed at the next call to setBand
    */
   public abstract function getBand();
   /*
    * If something goes wrong while pending between screens
    * the panic function is called.
    */
   public abstract function panic();
}

/* functions to deal with the function */
function screen_config_valid()
{
   if (file_exists(screen_config_file) && is_readable(screen_config_file)) return TRUE;

   Error::push("screen_config.php file does not exist. (".screen_config_file.")");
   Error::push("Exists (should be true): ".(file_exists(screen_config_file) ? "true" : "false" ));
   Error::push("Readable (should be true): ".(is_readable(screen_config_file) ? "true" : "false"));

   return FALSE;
}

function screen_config_load()
{
   include screen_config_file;

   if (!class_exists("Maschine"))
     {
        Error::push("Class Maschine does not exists in screen_config.php");
        return FALSE;
     }
   Instance::push("screen_config", new Maschine());
   return TRUE;
}
?>