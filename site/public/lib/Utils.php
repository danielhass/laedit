<?php
function error($error, $die = TRUE)
{
   echo "<html><body>";
   echo "<h4> Failed to bring up the site </h4>";
   echo $error."\n";
   echo "<br/>";
   echo "<br/>";
   Error::flush();
   echo "</body></html>";
   if ($die)
     die();
}

function createAnswer($exitcode,$answer = null, $log = "none", $screen = "none", $band = "none"){

   header('Content-type: text/xml');
   echo "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
   echo "<request>\n";
   echo "<exitcode>".$exitcode."</exitcode>\n";
   echo "<log>".$log."</log>\n";
   echo "<screen>".$screen."</screen>\n";
   echo "<band>".$band."</band>\n";
   echo "<answer>\n";
   //echo "<![CDATA[";
   echo $answer;
   //echo "]]>";
   echo "</answer>\n";
   echo "</request>\n";
   //end and flush the buffer !
   ob_end_flush();
   exit();
}

function login($auth)
{
   if (!isset($_POST['username']) || !isset($_POST['password']))
     createAnswer(-1, "No login params ... BAD");

   if (!$auth->login($_POST['username'], $_POST['password']))
     createAnswer(-1, "Login failed");
}

function output_array($arr)
{
   foreach($arr as $p)
      echo $p;
}


function content_get($path)
{
   $result = array();

   $dir = opendir($path);

   while($file = readdir($dir))
   {
      if( $file != "." && $file != "..")
         $result[$file] = file_get_contents($path."/".$file);
   }
   ksort($result);
   closedir($dir);
   return $result;
}

class Instance {

   private static $list = array();

   public static function push($name, $inst)
   {
      self::$list[$name] = $inst;
   }

   public static function get($name)
   {
      return self::$list[$name];
   }

}

?>