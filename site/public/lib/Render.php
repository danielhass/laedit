<?php
/*
 * Abstract class to Render a website
 * @author bu5hm4n
 *
 * Should be implemented by the Theme.php file of a instance
 */
abstract class Render
{
   /*
     Render the basic side which is displayed in the <body>
    */
   abstract function renderSite($title);
   /*
     Render a Screen,

     The given attribute screen is the type of the screen
     You have to fit the screens specifications,
     - login screen:
        Username and Password should be available via the js functions of the theme
        The button which triggers the login should call the workflow_continue() function.
     - edit screen:
        Attrbitues is a array of FilledAttributes,
        Should also contain a button which calls workflow_continue
        The new values of the attributes should be available via the js theme api
     - commit screen:
        Just a plain button which calls workflow_continue
        Attributes is a array of EditedAttributes.
     - end screen:
        Anothertime a button which calls workflow_end
   */
   abstract function renderScreen($screen, $attributes);

   /*
      Render a screen which is shown when the site is waiting for a response from the backend
    */
   abstract function renderWaitScreen($action);
}
?>