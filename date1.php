<?php
/*
*****************************************
***     PHP 5 Astuces d'experts       ***
***         Chapitre Date             ***
*** 		   Auteurs                ***  
***        Stephane Brissaud          ***
***		  Jean-marc Herellier         ***               
*****************************************

- Postez vos questions sur le forum : http://forum.astuces-php.info/
- Postez vos propres scripts : http://www.astuces-php.info/script.html
- Recherchez un emploi : http://www.astuces-php.info/offre-emploi-10-offres.html
- Postez votre demande d'emploi : http://www.astuces-php.info/demande-emploi-20-demandes.html
- Promotionnez votre site web : http://www.astuces-php.info/annuaire.html
- D�couvrez des ouvrages selection�s : http://www.astuces-php.info/livre.html
- Suivez l'actualit� d'astuces-php : http://www.astuces-php.info/newsletter.html

*/

session_start(); 

//<--- Afficher la date en fran�ais
$tb_jours = array('Sunday'=>'Dimanche', 
  'Monday'=>'Lundi', 
  'Tuesday'=>'Mardi', 
  'Wednesday'=>'Mercredi', 
  'Thursday'=>'Jeudi', 
  'Friday'=>'Vendredi', 
  'Saturday'=>'Samedi'); 
$tb_mois = array('01'=>'Janvier', 
  '02'=>'F�vrier', 
  '03'=>'Mars', 
  '04'=>'Avril', 
  '05'=>'Mai', 
  '06'=>'Juin', 
  '07'=>'Juillet', 
  '08'=>'Ao�t', 
  '09'=>'Septembre', 
  '10'=>'Octobre', 
  '11'=>'Novembre', 
  '12'=>'D�cembre'); 
$datejour = strtr(strftime("%A"), $tb_jours) 
  . " " . date("j") 
  . " " . strtr(strftime("%m"),$tb_mois) 
  . " " . date("Y"); 
echo "$datejour <br>"; 
echo $_SERVER["REMOTE_ADDR"] . '<br>';

$action = $_GET["action"];
//echo "$action  <br>"; 


//<--- R�cup�rer les dates de visite d'un utilisateur    
    
if ($fp = fopen("last_visit.txt", "a")) 
{  
   // session_start();  
   //if (!session_is_registered("u_sessid")) 
   { 
   $sess_date = Date("d/m/Y H:i:s");  
   fwrite($fp, "$sess_date\t".$_SERVER["REMOTE_ADDR"]."\n"); 
   } 
   fclose($fp);  
   session_register("u_sessid");      
   echo "La date de derni�re visite a �t� enregistr�e<br>"; 
   echo "<a href='" . $PHP_SELF . "?action=liste'>Voir le fichier des visites</a>"; 
}   
else 
{ 
   echo "Erreur d'ouverture du fichier last_visit.txt<br>"; 
} 

if ($action == "liste") 
{    
  if ($fp = fopen("last_visit.txt", "r")) {  
    echo "<table align='center' border='1' 
      width='50%' cellspacing='0' cellpadding='0'><tr> 
      <tr><td align='center'><b>Utilisateur(s)<b></td> 
      <td align='center'><b>Date de derni�re visite</b></td> 
      </tr>"; 
    while($u_connect = fscanf($fp, "%s\t%s\t%s\n")) { 
      list($u_date, $u_heure, $u_ip)=$u_connect; 
      echo "<tr><td align='center'>" 
        . $u_ip 
        . "</td><td align='center'>" 
        . $u_date . " " . $u_heure . "</td></tr>"; 
    } 
    echo "</table>"; 
    fclose($fp);  
} 

else 

{ 
    echo "Erreur d'ouverture du fichier last_visit.txt<br>"; 
}   

}
