<?php 
/* [EDIT by danbrown AT php DOT net: 
   The author of this note named this 
   file tmp.php in his/her tests. If 
   you save it as a different name, 
   simply update the links at the 
   bottom to reflect the change.] */ 

session_start(); 

$sessPath   = ini_get('session.save_path'); 
$sessCookie = ini_get('session.cookie_path'); 
$sessName   = ini_get('session.name'); 
$sessVar    = 'foo'; 

echo '<br>sessPath: ' . $sessPath; 
echo '<br>sessCookie: ' . $sessCookie;
echo '<br>sessName: ' . $sessName; 

echo '<hr>'; 

if( !isset( $_GET['p'] ) ){ 
    // instantiate new session var 
    $_SESSION[$sessVar] = 'hello world'; 
}else{ 
    if( $_GET['p'] == 1 ){ 

        // printing session value and global cookie PHPSESSID 
        echo $sessVar . ': '; 
        if( isset( $_SESSION[$sessVar] ) ){ 
            echo $_SESSION[$sessVar]; 
        }else{ 
            echo '[not exists]'; 
        } 

        echo '<br>' . $sessName . ': '; 

        if( isset( $_COOKIE[$sessName] ) ){ 
        echo $_COOKIE[$sessName] . '-111111<br>'; 
        }else{ 
            if( isset( $_REQUEST[$sessName] ) ){ 
            echo $_REQUEST[$sessName] . '222222<br>'; 
            }else{ 
                if( isset( $_SERVER['HTTP_COOKIE'] ) ){ 
                echo $_SERVER['HTTP_COOKIE'] . '3333333<br>'; 
                }else{ 
                echo 'problem, check your PHP settings'; 
                } 
            } 
        } 

    }else{ 

        // destroy session by unset() function 
        unset( $_SESSION[$sessVar] ); 

        // check if was destroyed 
        if( !isset( $_SESSION[$sessVar] ) ){ 
            echo '<br>'; 
            echo $sessName . ' was "unseted"'; 
        }else{ 
            echo '<br>'; 
            echo $sessName . ' was not "unseted"'; 
        } 

    } 
} 
echo 'PHP_SELF :' . $_SERVER['PHP_SELF'] . '<br>';
echo 'GATEWAY_INTERFACE :' . $_SERVER['GATEWAY_INTERFACE'] . '<br>';
echo 'PHP_SELF :' . $_SERVER['SERVER_ADDR'] . '<br>';
echo 'SERVER_ADDR :' . $_SERVER['SERVER_NAME'] . '<br>';
echo 'SERVER_SOFTWARE :' . $_SERVER['SERVER_SOFTWARE'] . '<br>';
echo 'SERVER_PROTOCOL :' . $_SERVER['SERVER_PROTOCOL'] . '<br>';
echo 'REQUEST_METHOD :' . $_SERVER['REQUEST_METHOD'] . '<br>';
echo 'REQUEST_TIME :' . $_SERVER['REQUEST_TIME'] . '<br>';
echo 'QUERY_STRING :' . $_SERVER['QUERY_STRING'] . '<br>';
echo 'DOCUMENT_ROOT :' . $_SERVER['DOCUMENT_ROOT'] . '<br>';
echo 'HTTP_ACCEPT :' . $_SERVER['HTTP_ACCEPT'] . '<br>';
echo 'HTTP_ACCEPT_CHARSET :' . $_SERVER['HTTP_ACCEPT_CHARSET'] . '<br>';
echo 'HTTP_ACCEPT_ENCODING :' . $_SERVER['HTTP_ACCEPT_ENCODING'] . '<br>';
echo 'HTTP_ACCEPT_LANGUAGE :' . $_SERVER['HTTP_ACCEPT_LANGUAGE'] . '<br>';
echo 'HTTP_CONNECTION :' . $_SERVER['HTTP_CONNECTION'] . '<br>';
echo 'HTTP_HOST :' . $_SERVER['HTTP_HOST'] . '<br>';
echo 'HTTP_REFERER :' . $_SERVER['HTTP_REFERER'] . '<br>';
echo 'HTTP_USER_AGENT :' . $_SERVER['HTTP_USER_AGENT'] . '<br>';
echo 'HTTPS :' . $_SERVER['HTTPS'] . '<br>';
echo 'REMOTE_ADDR :' . $_SERVER['REMOTE_ADDR'] . '<br>';
echo 'REMOTE_HOST :' . $_SERVER['REMOTE_HOST'] . '<br>';
echo 'REMOTE_PORT :' . $_SERVER['REMOTE_PORT'] . '<br>';
echo 'SCRIPT_FILENAME :' . $_SERVER['SCRIPT_FILENAME'] . '<br>';
echo 'SERVER_ADMIN :' . $_SERVER['SERVER_ADMIN'] . '<br>';
echo 'SERVER_PORT :' . $_SERVER['SERVER_PORT'] . '<br>';
echo 'SERVER_SIGNATURE :' . $_SERVER['SERVER_SIGNATURE'] . '<br>';
echo 'PATH_TRANSLATED :' . $_SERVER['PATH_TRANSLATED'] . '<br>';
echo 'SCRIPT_NAME :' . $_SERVER['SCRIPT_NAME'] . '<br>';
echo 'REQUEST_URI :' . $_SERVER['REQUEST_URI'] . '<br>';
echo 'PHP_AUTH_DIGEST :' . $_SERVER['PHP_AUTH_DIGEST'] . '<br>';
echo 'PHP_AUTH_USER :' . $_SERVER['PHP_AUTH_USER'] . '<br>';
echo 'PHP_AUTH_PW :' . $_SERVER['PHP_AUTH_PW'] . '<br>';
echo 'AUTH_TYPE :' . $_SERVER['AUTH_TYPE'] . '<br>';

?> 
<hr>

<a href=tmp.php?p=1>test 1 (printing session value)</a> 
<br> 
<a href=tmp.php?p=2>test 2 (kill session)</a> 