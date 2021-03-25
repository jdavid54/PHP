<?PHP

// ********************************************
// Nom du script : test-mesure-debit-bande-passante.php
// Auteur : sebastien.fontaine@frameIP.com.pas.de.spam
// Date de cr�ation : 14 Septembre 2006
// version : 1.1
// Licence : Ce script est libre de toute utilisation.
//           La seule condition existante est de faire r�f�rence au site http://www.frameip.com afin de respecter le travail d'autrui.
// ********************************************

// ********************************************
// Initiation des variables
// ********************************************
$duree_du_test=4;

// ********************************************
// Affichage de l'ent�te
// ********************************************
echo 
	'
	<p class="titre-principal">
		Mesure du d�bit de votre acc�s Internet
	</p>

	<p class="chapitre---texte-de-niveau-1" style="text-align: center">
		<br>
		<a href="http://www.frameip.com/test-mesure-debit-bande-passante/">
			<img border="1" name="barre-d-attente" src="barre-d-attente.gif" width="299" height="16">

		</a>
	</p>
	';

// ********************************************
// Echo de la chaine d�sactivant l'affichage
// ********************************************
echo "<!--";

// ********************************************
// Qualibrage de la taille
// ********************************************
$taille=($duree_du_test/envoi_des_donnnes(100000))*100000;
	
// ********************************************
// Test r�el
// ********************************************
$debit=round(8*$taille/1000/envoi_des_donnnes($taille),0);

// ********************************************
// Echo de la chaine r�activant l'affichage
// ********************************************
echo "-->";

// ********************************************
// Affichage des r�sultats
// ********************************************
echo
	'
	<p class="chapitre---texte-de-niveau-1" style="text-align: center">
		Votre d�bit � l\'instant T est de :
	<br>
	<br>
	<b>
		<font size="7">
			'.$debit.' Kbps
		</font>
	</b>
	<br>
	<br>
	<a href="test-mesure-debit-bande-passante.php">
		Cliquez ici pour effectuer un nouveau test
	</a>
	</p>
	';

function envoi_des_donnnes($taille)
	{
	// ********************************************
	// Initiation des variables
	// ********************************************
	$donnee="www.frameip.com ";

	// ********************************************
	// R�cup�ration du temps avant envoi
	// ********************************************
	$temps_avant_envoi=microtime();

	// ********************************************
	// Envoi des donn�es
	// ********************************************
	for ($i=0;$i<$taille/16;$i++)
		echo $donnee;

	// ********************************************
	// R�cup�ration du temps apres envoi
	// ********************************************
	$temps_apres_envoi=microtime();

	// ********************************************
	// Convertion des temps
	// ********************************************
	$tampon=explode(" ",$temps_avant_envoi);
	$temps_avant_envoi=((float)$tampon[0]+(float)$tampon[1]);
	$tampon=explode(" ",$temps_apres_envoi);
	$temps_apres_envoi=((float)$tampon[0]+(float)$tampon[1]);

	// ********************************************
	// Retourne le temps d�coul�
	// ********************************************
	return($temps_apres_envoi-$temps_avant_envoi);
	}

?>
