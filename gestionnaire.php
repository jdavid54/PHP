<html>
<head>
<STYLE>
body {  
font-family: Arial, Helvetica, sans-serif; 
font-size: 10px; 
color: #000000; 
text-decoration: none;
}
a { 
font-family: Arial, Helvetica, sans-serif;  
color: #333333; 
text-decoration: none;
}
a:visited {  
text-decoration: none;
}
a:hover {  
text-decoration: underline overline;
}
.bloc{
font-size: 12px; 
color: #000000; 
}

</STYLE>
<title>Gestionnaire de fichier</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body>
<?php
/*
*****************************************
***     PHP 5 Astuces d'experts       ***
***  Chapitre Dossiers / Fichiers     ***
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
  include("gestionnaire.inc.php");

/*
function menu() 
	function get_general_info($path) 
	function get_file_taille($valeur) 
	function get_file_perms($path) 
	function get_file_size($path) 
	function get_file_lastupdate($path) 

	function traverse($path, $recursif=0) 
	function list_file() 
	function NewFileForm() 
	function make_file() 
	function view_file() 
	function NewDirForm() 
	function make_dir() 
	function UploadForm() 
	function UploadFile() 
	function valid_upload($error) 
	function delete() 
*/
  $action = (isset($_REQUEST['action']) ? $_REQUEST['action'] : '');

	switch($action) {
		case"view_file":
			view_file();
			break;
		case"list_file":
			list_file();
			break;
		case"NewFileForm":
			//NewFileForm();
			break;
		case"make_file":
			//make_file();
			break;
		case"NewDirForm":
			//NewDirForm();
			break;
		case"make_dir":
			//make_dir();
			break;
		case"UploadForm":
			//UploadForm();
			break;
		case"UploadFile":
			//UploadFile();
			break;
		case"delete":
			//delete();
			break;
		default:
			list_file();
			break;
	}
?>
</body>
</html>
