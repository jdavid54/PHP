<?php
 
// ********************************************
// Nom du script : whois.php
// Auteur : 
// Date de création : 
// version : // Licence : Ce script est libre de toute utilisation.
//           La seule condition existante est de faire référence au site http://www.frameip.com afin de respecter le travail d'autrui.
// ********************************************
 
// ********************************************
// Affichage de l'entete html
// ********************************************

echo
      '
      <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
 
      <html>
 
      <head>
 
      <LINK REL="StyleSheet" HREF="../style.css" TYPE="text/css">
 
      <title>Get distant IP, Name and Environment</title>
 
      <META http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
            
      </head>
 
      <body>
      ';
 
$ip = $_SERVER['REMOTE_ADDR']; // retourne l'adresse IP de l'utilisateur 
$dns = gethostbyaddr($ip); // Nom du host de l'utilisateur 
$env = $_SERVER['HTTP_USER_AGENT']; // environement de l'utilisateur 
$ref = $_SERVER['HTTP_REFERER']; // Liens qui a conduit vers cette page 
 
echo '
      <p align="center">
            <font size="4" color="#008000">
                  <b>
                        Get IP
                  </b>
            </font>
      </p>
      <p>
            Votre adresse IP : '.$ip.'
            <br>
           
            Votre nom : '.$dns.'
            <br>
        Votre environnement : '.$env.'
            <br>
            &nbsp;
      </p>
      ';

echo
            '
            </body>
 
            </html>
            ';
 exit(0);

//Citation: 
//$sock = fsockopen ($Host, 80, $errno, $errstr); 
//if (!$sock) 
//{ 
// Il y a eu une erreur 
//echo "Une erreur s'est produite<br>\n"; 
//echo "Numéro d'erreur : $errno<br>\n"; 
//echo "Description : $errstr<br>\n"; 
?>