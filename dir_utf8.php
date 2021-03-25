<?php
$dir_handle = opendir(".");
while (false !== ($file = readdir($dir_handle)))
{
  echo utf8_encode($file)."<br>";
}
?>