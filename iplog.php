<?php
$IP = $_SERVER['REMOTE_ADDR'];
$p = fopen("iplogs.txt", "a");
$aujourdhui = date("F j, Y, g:i a"); 
echo "$aujourdhui -> Log $IP<br>";
fwrite($p, $aujourdhui);
fwrite($p, " -> ");
fwrite($p, $IP);
fwrite($p, "
");
fclose($p);
?>