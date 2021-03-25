<?php
//Don't forget, because $_REQUEST is a different variable than $_GET and $_POST, it is treated as such in PHP -- modifying $_GET or $_POST elements at runtime will not affect the ellements in $_REQUEST, nor vice versa. e.g:

$_GET['foo'] = 'a';
$_POST['bar'] = 'b';

var_dump($_GET); // Element 'foo' is string(1) "a"
echo '<br>';
var_dump($_POST); // Element 'bar' is string(1) "b"
echo '<br>';
var_dump($_REQUEST); // Does not contain elements 'foo' or 'bar'
echo '<br>';
?>


<?php
//If you want to evaluate $_GET and $_POST variables by a single token without including $_COOKIE in the mix, use  $_SERVER['REQUEST_METHOD'] to identify the method used and set up a switch block accordingly, e.g:

echo $_SERVER['REQUEST_METHOD'];
switch($_SERVER['REQUEST_METHOD'])
{
case 'GET': $the_request = &$_GET; break;
case 'POST': $the_request = &$_POST; break;
default:
}

echo $the_request;
?>