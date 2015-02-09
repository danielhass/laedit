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
         $result[] = file_get_contents($path."/".$file);
   }
   closedir($dir);
   return $result;
}
?>