<?php
/*
*****************************************
***     PHP 5 Astuces d'experts       ***
***   Chapitres - Traiter les IP      ***
*** 		    Auteurs               ***  
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

//<--- Connaitre l'adresse IP d'un visiteur
function getIP() { 
  if (getenv("HTTP_CLIENT_IP")) { 
    $ip = $_SERVER['HTTP_CLIENT_IP']; 
  } 
  elseif(getenv("HTTP_X_FORWARDED_FOR")) { 
    $ip = $_SERVER['HTTP_X_FORWARDED_FOR']; 
  } 
  elseif(getenv("REMOTE_ADDR")) { 
    $ip = $_SERVER['REMOTE_ADDR']; 
  } 
  else $ip = "inconnue"; 
  return $ip; 
} 

//<--- A quel domaine correspond une adresse IP ? 
$ip = '212.37.221.109'; 
$host = gethostbyaddr($ip); 
echo "Le domaine associé à l'adresse $ip est <b>$host</b><br>"; 
$ip = $_SERVER['REMOTE_ADDR']; 
$host = gethostbyaddr($ip); 
echo "Votre adresse IP est : $ip<br>"; 
echo "Le nom de domaine associé à cette IP est : $host<br>"; 

//<--- Quelle est l'IP d'un domaine ? 
$host = 'yahoo.com'; 
$ip = gethostbyname($host); 
echo "Nom de domaine : $host<br>"; 
echo "Adresse IP associée : $ip<br>";  
$liste_ip = gethostbynamel('www.yahoo.com'); 
print_r($liste_ip); 

//<--- Récupération des infos pour une IP 

class ip_infos 

{ 
  // --- variables 
  var $msg_erreur = 'Msg='; 
  var $erreur = 0; 
  var $serveur_whois = 'whois.arin.net'; 
  var $serveur_whois2 = ''; 
  var $whois_texte = ''; 

  function ip_info($ip) 
  { 
    // --- IP valide ? 
    $host = gethostbyaddr($ip); 
    if (!$ip == gethostbyname($host)) 
    { 
      $this->msg_erreur .= '$ip = adresse IP ';
      $this->erreur = 1; 
	  echo "$this->msg_erreur<br>$this->erreur<br>"; 
    } 
	echo "Votre adresse IP est : $ip<br>"; 
	echo "Votre host est : $host<br>"; 
	echo "$this->msg_erreur<br>$this->erreur<br>";
    // --- connexion au serveur whois 
    if (!$this->erreur) 
	echo "$this->serveur_whois<br>";
	$sock = @fsockopen($this->serveur_whois, 43, $num, $error, 20);
    { 
      if (!$sock) 
      { 
        unset($sock); 
        $this->msg_erreur .= 'Connexion impossible au serveur ' 
          . $this->serveur_whois.' (port 43)'; 
        $this->erreur = 2; 
      } 
    } 
    // --- lecture des infos
	echo "$this->msg_erreur<br>$this->erreur<br>";
    if (!$this->erreur) 
    { 
      $this->whois_texte = ''; 
      fputs($sock, $ip.'\n'); 
      while (!feof($sock)) 
      { 
        $this->whois_texte .= fgets($sock, 10240); 
      } 
      fclose($sock); 
      // --- serveur whois complémentaire ? 
      if (eregi('RIPE.NET', $this->whois_texte)) 
      { 
        $this->serveur_whois2 = "whois.ripe.net"; 
      } 
      elseif (eregi('whois.apnic.net', $this->whois_texte)) 
      { 
        $this->serveur_whois2 = 'whois.apnic.net'; 
      } 
      elseif (eregi('nic.ad.jp', $this->whois_texte)) 
      { 
        $this->serveur_whois2 = 'whois.nic.ad.jp'; 
        // --- suppression des caractères japonais sur JPNIC 
        $flag = '/e'; 
      } 
      elseif (eregi('whois.registro.br', $this->whois_texte)) 
      { 
        $this->serveur_whois2 = 'whois.registro.br'; 
      } 
    } 
    // --- interrogation du second serveur whois
	echo "$this->msg_erreur<br>$this->erreur<br>";
    if($this->serveur_whois2 && !$this->erreur) 
    { 
      $this->whois_texte = ''; 
      if(! $sock = fsockopen($this->serveur_whois2, 43, $num, $error, 10)) { 
        unset($sock); 
        $this->msg_erreur .= 'Connexion impossible au serveur ' 
          . $this->serveur_whois2 .' (port 43)'; 
      } 
      else { 
        fputs($sock, $ip.$flag.'\n'); 
        while (!feof($sock)) { 
          $this->whois_texte .= fgets($sock, 10240); 
        } 
        fclose($sock); 
      } 
    } 

    echo "$this->msg_erreur<br>$this->erreur<br>";
    if(!$this->erreur) 
    { 
     $tb_lignes = explode(chr(10), $this->whois_texte); 
     $this->infos = array(); 

     for ($i=0; $i<count($tb_lignes); $i++) 
     { 
       $tmptb = explode(':', $tb_lignes[$i]); 

       if (count($tmptb) > 1 && substr($tmptb[0], 0, 1)!='%') 
       { 
         $key = trim($tmptb[0]); 
         $val = trim($tmptb[1]); 

         if(strlen($this->infos["$key"]) > 0) 
         { 
           $this->infos['$key'] .= ', ' . $val; 
         } 
       elseif ('$key') $this->infos['$key'] = $val; 
       } 
     } 
    }
  } 
}  

$test = new ip_infos;
$ip = $_SERVER['REMOTE_ADDR'];
echo "Votre adresse IP est : $ip<br>"; 
$test->ip_info($ip);
?>  