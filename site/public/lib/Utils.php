<?php
function error($error)
{
   echo $error."\n";
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