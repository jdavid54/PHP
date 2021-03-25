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
- Découvrez des ouvrages selectionés : http://www.astuces-php.info/livre.html
- Suivez l'actualité d'astuces-php : http://www.astuces-php.info/newsletter.html

*/

//<--- Éphéméride
if (!isset($_POST["jour"])) $jour = date("d"); 
  if (!isset($_POST["mois"])) $mois = date("m");  
  $pointeur = fopen("ephemeride.txt", "r"); 
  while ($tab=fscanf($pointeur, "%s\t%s\t%s\n")) { 
    list ($m, $j, $fete) = $tab; 
 
      if ($m == $mois && $j == $jour) { 
        echo "Nous sommes le $j $m " . date("Y") . "<br>"; 
        echo "Pensez à fêter les $fete <br>"; 
      } 

  } 
  fclose($pointeur);
?>

 
