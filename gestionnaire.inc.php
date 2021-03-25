<?php
/*
*****************************************
***     PHP 5 Astuces d'experts       ***
***  Chapitre Dossiers / Fichiers     ***
*** 		    Auteurs           ***
***        Stephane Brissaud          ***
***	 Jean-marc Herellier          ***
*****************************************

- Postez vos questions sur le forum : http://forum.astuces-php.info/
- Postez vos propres scripts : http://www.astuces-php.info/script.html
- Recherchez un emploi : http://www.astuces-php.info/offre-emploi-10-offres.html
- Postez votre demande d'emploi : http://www.astuces-php.info/demande-emploi-20-demandes.html
- Promotionnez votre site web : http://www.astuces-php.info/annuaire.html
- Découvrez des ouvrages selectionés : http://www.astuces-php.info/livre.html
- Suivez l'actualité d'astuces-php : http://www.astuces-php.info/newsletter.html

*/
define("COLOR1", "#00FF99");
define("COLOR2", "#CCCCCC");
define("RACINE", ".");

	function menu() {
		$txt = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="bloc">';
		$txt .= '<tr><td align="center"><a href="' . $_SERVER['PHP_SELF'] . '?action=NewFileForm">Créer un fichier</a></td>';
		$txt .= '<td align="center"><a href="' . $_SERVER['PHP_SELF'] . '?action=NewDirForm">Créer un dossier</a></td>';
		$txt .= '<td align="center"><a href="' . $_SERVER['PHP_SELF'] . '?action=UploadForm">Upload de fichier</a></td></tr>';
		$txt .= '</table>';
		return $txt;
	}

	function get_general_info($path) {
		$poids_total = 0;
		$tab_contenu = traverse($path, 1);
		$nb_file = count($tab_contenu);
		for($i=0;$i<count($tab_contenu);$i++) {
			$poids_total += get_file_size($tab_contenu[$i]);
		}
		$txt_info = '<table align="center" width="100%" border="0" cellspacing="5" cellpadding="0" class="bloc">';
		$txt_info .= '<tr>';
    	$txt_info .= '<td width="120">Nombres de fichiers : </td>';
    	$txt_info .= '<td width="100">' . $nb_file . '</td>';
		$txt_info .= '<td width="140">Pour un poids total de : </td>';
		$txt_info .= '<td>' . get_file_taille($poids_total) . '</td>';
		$txt_info .= '<td width="50%">&nbsp;</td>';
		$txt_info .= '</tr>';
		$txt_info .= '<tr>';
		$txt_info .= '<td colspan="5"><hr></td>';
		$txt_info .= '</table>';
		return $txt_info;
	}

	function get_file_taille($valeur) {
		$txt = '';
		if ($valeur>=1000000) {
   			$txt = $valeur/1000000;
   			$txt = number_format($txt, 2)." Mo";
  		}
  		elseif ($valeur>=1000) {
   			$txt = $valeur/1000;
   			$txt = number_format($txt, 2)." Ko";
  		}
  		elseif ($valeur>=0) {
   			$txt= $valeur." octect";
   			if ($valeur>0) {
    		$txt .= "s";
  			}
			else {
				$txt = $valeur;
			}
		}
 		else {
  			$txt = $valeur;
 		}
		return $txt;
	}

	function get_file_perms($path) {
		$p = fileperms($path);
		if (($p & 0xC000) == 0xC000) {
    		$txt = 's';
		}
		elseif (($p & 0xA000) == 0xA000) {
    		$txt = 'l';
		}
		elseif (($p & 0x8000) == 0x8000) {
    		$txt = '-';
		}
		elseif (($p & 0x6000) == 0x6000) {
    		$txt = 'b';
		}
		elseif (($p & 0x4000) == 0x4000) {
    		$txt = 'd';
		}
		elseif (($p & 0x2000) == 0x2000) {
    		$txt = 'c';
		}
		elseif (($p & 0x1000) == 0x1000) {
    		$txt = 'p';
		}
		else {
    		$txt = 'u';
		}
		$txt .= (($p & 0x0100) ? 'r' : '-');
		$txt .= (($p & 0x0080) ? 'w' : '-');
		$txt .= (($p & 0x0040) ? (($p & 0x0800) ? 's' : 'x' ) :(($p & 0x0800) ? 'S' : '-'));
		$txt .= (($p & 0x0020) ? 'r' : '-');
		$txt .= (($p & 0x0010) ? 'w' : '-');
		$txt .= (($p & 0x0008) ? (($p & 0x0400) ? 's' : 'x' ) : (($p & 0x0400) ? 'S' : '-'));
		$txt .= (($p & 0x0004) ? 'r' : '-');
		$txt .= (($p & 0x0002) ? 'w' : '-');
		$txt .= (($p & 0x0001) ? (($p & 0x0200) ? 't' : 'x' ) : (($p & 0x0200) ? 'T' : '-'));
		return $txt;
	}

	function get_file_size($path) {
		if (is_file($path)) {
			$val = filesize($path);
		}
		else {
			$val ='';
		}
		return $val;
	}

	function get_file_lastupdate($path) {
		if(is_file($path)) {
			$val = filemtime($path);
		}
		else {
			$val = '';
		}
		return $val;
	}

	function traverse($path, $recursif=0) {
		$tab_contenu = array();
		if (strlen($path) > 0 && is_dir($path)) {
			if ($pointeur = opendir($path)) {
				while (false !== ($file = readdir($pointeur))) {
					if ($file != "." && $file != "..") {
						if(is_dir($path . "/" . $file) && $recursif == 1) {
							$tab_contenu = array_merge($tab_contenu, traverse($path . "/" . $file, 1));
						}
						else {
							$tab_contenu[] = $path . '/' . $file;
						}
					}
    			}
				closedir($pointeur);
			}
		}
		return $tab_contenu;
	}


	function list_file() {
		$color1 = COLOR1;
		$color2 = COLOR2;
		$path = (isset($_GET['path']) ? $_GET['path'] : ".");
		$rep = RACINE;
		$tab_contenu = traverse($path, 1);
		echo get_general_info($path);
		if($rep != $path) $tab_contenu = array_merge(array('.'), $tab_contenu);
		if (count($tab_contenu) > 0) {
			//echo menu();
			$txt = '<hr><table width="100%" border="0" cellspacing="0" cellpadding="0" class="bloc">';
			$txt .= '<tr bgcolor="#CCCCCC"><td align="center"><b>Fichier</b></td><td align="center"><b>Type</b></td>';
			$txt .= '<td align="center"><b>Poids</b></td><td align="center"><b>Dernière MAJ</b></td>';
			$txt .= '<td align="center"><b>Droits</b></td><td align="center"><b>Actions</b></td></tr>';
			for($i=0;$i<count($tab_contenu);$i++) {
				$color=$color1;
				$color1=$color2;
				$color2=$color;
				$file_path = $tab_contenu[$i];
				$path_info[] = pathinfo($file_path);
				if(isset($path_info[$i]['basename'])) {               //178
					$txt .= '<tr bgcolor="' . $color .'">';
					$txt .= '<td width="200" height="20">';
					$txt .= '<a href="download.php?filname=' . $path_info[$i]['basename'] . '">' . $path_info[$i]['dirname'] . '/' . $path_info[$i]['basename'] . '</a>';
					$txt .= '</td>';
					$txt .= '<td align="center">';
					if(isset($path_info[$i]['extension'])) {
						$txt .= $path_info[$i]['extension'];
					}
					$txt .= '</td>';
					$txt .= '<td align="center">' . get_file_taille(get_file_size($file_path)) . '</td>';
					$txt .= '<td align="center">' . strftime("%d/%m/%Y %H:%M", strtotime(get_file_lastupdate($file_path))) . '</td>';  //189
					$txt .= '<td align="center">' . get_file_perms($file_path) . '</td>';
					$txt .= '<td align="center" width="15%">';
					if(!is_dir($file_path)) {
						if(preg_match("[php|html|htm|inc|asp|txt|log]",$path_info[$i]['extension'])) {
							$txt .= '<a href="' . $_SERVER['PHP_SELF'] . '?action=view_file&mode=f&path=' . $file_path . '">Visualiser</a>&nbsp;';
							//$txt .= '<a href="' . $_SERVER['PHP_SELF'] . '?action=NewFileForm&mode=update&path=' . $file_path . '">Modifier</a>&nbsp;';
						}
						elseif(preg_match("[gif|jpg|jpeg|png|swf]",$path_info[$i]['extension'])) {
							$txt .= '<a href="' . $_SERVER['PHP_SELF'] . '?action=view_file&mode=i&path=' . $file_path . '">Visualiser</a>&nbsp;';
						}
					}
					else {
						if(isset($path_info[$i]['extension'])) {
							if(preg_match("[php|txt|inc|asp|htm|html|log]",$path_info[$i]['extension'])) {
								$txt .= '<a href="' . $_SERVER['PHP_SELF'] . '?action=view_file&mode=f&path=' . $file_path . '/">Visualiser</a>&nbsp;';
							}
							elseif(preg_match("[gif|jpg|jpeg|png]",$path_info[$i]['extension'])) {
								$txt .= '<a href="' . $_SERVER['PHP_SELF'] . '?action=view_file&mode=i&path=' . $file_path . '">Visualiser</a>&nbsp;';

							}
							else {
								$txt .= 'Format non supporté par votre navigateur';
							}
						}
					}
					/*
					$txt .= "<a href='" . $_SERVER['PHP_SELF'] . "?action=delete&dpath=" . $file_path . "' OnClick='return confirm(\"êtes vous sûr de vouloir supprimer le fichier :\\r\\n" . $file_path . " ?\");'>Supprimer</a>&nbsp;";
					*/
					$txt .= '</td></tr>';
				}
			}
				$txt .= '</table><hr>';
				echo $txt;
				//echo menu();
		}
		else {
			echo "Erreur : Dossier non accessible.";
		}
	}
//227
	function NewFileForm() {
		$path = (isset($_GET['path']) ? $_GET['path'] : '.');
		$mode = (isset($_GET['mode']) ? $_GET['mode'] : 'create');
		$content = '';
		if($path != '.' && $mode != 'create') {
			$tb = pathinfo($path);
		}
		$txt = '<table align="center" width="70%" border="0" cellspacing="5" cellpadding="0" class="bloc">';
		$txt .= '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$txt .= '<input type="hidden" name="action" value="make_file">';
		switch($mode) {
			case"create":
			$txt .= '<input type="hidden" name="mode" value="create">';
		break;
			case"update":
			$txt .= '<input type="hidden" name="mode" value="update">';
			if(file_exists($path)) {
				$file_path = $tb['dirname'].'/'.$tb['basename'];
				$pointeur = fopen($file_path, "r");
				while (!feof($pointeur)) {
					$content .= fgets($pointeur, filesize($file_path));
				}
			}
		break;
		}
		$txt .= '<tr>';
		$txt .= '<td width="50%">Chemin vers le fichier :<br>Si les dossiers n\'existent pas ils seront créés</td>';
		$txt .= '<td><input type="text" name="file" size="40" value="' . (isset($file_path) ? $file_path : '') . '"><br>Format : ./dossier1/dossier2/fichier.txt</td>';
		$txt .= '</tr>';
		$txt .= '<tr>';
		$txt .= '<td colspan="2" align="center">Contenu :</td>';
		$txt .= '</tr>';
		$txt .= '<tr>';
		$txt .= '<td colspan="2">';
		$txt .= '<textarea name="contenu" rows="20" cols="80">' . (isset($content) ? $content : '') . '</textarea>';
		$txt .= '</td>';
		$txt .= '</tr>';
		$txt .= '<tr>';
		$txt .= '<td colspan="2"><input type="submit" name="Submit" value="Enregistrer"></td>';
		$txt .= '</tr>';
		$txt .= '</form>';
		$txt .= '</table>';
		echo $txt;
	}
//272
	function make_file() {
	$file = (isset($_POST['file']) ? $_POST['file'] : '');
	$contenu = (isset($_POST['contenu']) ? $_POST['contenu'] : '');
	$mode = (isset($_POST['mode']) ? $_POST['mode'] : 'create');
	$ch ='';
	$txt='';

	if(strlen($file) > 0) {
		$tb_info = pathinfo($file);
		if(preg_match("[php|txt|inc|asp|htm|html|log]",$tb_info['extension'])) {
			if(isset($tb_info['dirname'])) {
				$tb_dir = explode("/", $tb_info['dirname']);

			}
			else {
				$tb_dir = '';
				$ch .= $tb_info['basename'];
			}
		}
		else {
			echo "<center>ERREUR : Le format : " . $tb_info['extension'] . " n'est pas accepté<br><a href='" . $_SERVER['PHP_SELF'] . "'>Retour</a></center>";
			exit;
		}

		if(is_array($tb_dir)) {
			$txt .='';
			for($i=0;$i<count($tb_dir);$i++)  {
				$dir = $ch . $tb_dir[$i];
				if(!is_dir($dir)) {
					if(mkdir($dir)) {
						$txt .= 'INFO : création de ' . $dir . '<br>';
						$ch .= $tb_dir[$i].'/';
					}
				}
				else {
					$txt .= 'INFO : Dossier existant : ' . $dir . '<br>';
					$ch .= $tb_dir[$i].'/';
				}
			}
			$ch .= $tb_info['basename'];
			if(!file_exists($ch)) {
				if ($pointeur = fopen($ch, "w+")) {
					$txt .= 'INFO : création de ' . $ch;
					fwrite($pointeur, $contenu);
					fclose($pointeur);
					chmod($ch, 0774);
				}
			}
			else {
				if($mode == 'update') {
					if ($pointeur = fopen($ch, "w")) {
						$txt .= 'INFO : Mise à  jour de ' . $ch;
						fwrite($pointeur, $contenu);
						fclose($pointeur);
						chmod($ch, 0774);
					}
				}
				else {
					$txt .= 'ERREUR : lors de l\'écriture de ' . $ch  . '<br>';
				}
			}
		}
		else {
			if(!file_exists($ch)) {
				if (fopen($ch, "w+")) {
					$txt .= 'creation : ' . $ch;
				}
			}
			else {
				if($mode == 'update') {
					if ($pointeur = fopen($ch, "w")) {
						$txt .= 'Mise à  jour : ' . $ch;
						fwrite($pointeur, $contenu);
						fclose($pointeur);
					}
				}
				else {
					$txt .= 'Erreur : lors de l\'écriture de ' . $ch  . '<br>';
				}
			}
		}
		echo $txt.'<hr>';
		//list_file($ch);
	}
}

	function view_file() {
		$path = (isset($_GET['path']) ? $_GET['path'] : './');
		$mode = (isset($_GET['mode']) ? $_GET['mode'] : 'f');
		if($mode == 'f') {
			$tb = pathinfo($path);
			$file = $tb['basename'];
			$dir = $tb['dirname'];
			$content = '<table width="80%" align="center" border="0" cellcpacing="5" cellpadding="0" class="bloc">';
			$content .= '<tr><td>Fichier : <b>' . $file . '</b></td><td align="right">Poids : <b>' . get_file_taille(get_file_size($dir.'/'.$file)) . '</b></td></tr>';
			$content .= '<tr><td align="center" colspan="2"><hr></td></tr>';
			$content .= '<tr><td colspan="2">';
			$pointeur = fopen($path, "r");
			while (!feof($pointeur)) {
				$content .= fgets($pointeur, filesize($path));
				$content = str_replace("\r\n", "<br>", $content);
			}
			fclose ($pointeur);
			$content .= '</td></tr>';
			$content .= '<tr><td align="center" colspan="2"><hr></td></tr>';
			$content .= '<tr><td align="center" colspan="2"><a href="' . $_SERVER['PHP_SELF'] . '">Retour</a></td></tr>';
			$content .= '</table>';
		}
		elseif($mode == 'i') {
		$tb = pathinfo($path);
			$file = $tb['basename'];
			$dir = $tb['dirname'];
			$content = '<table align="center" border="0" cellcpacing="5" cellpadding="0" class="bloc">';
			$content .= '<tr><td>Fichier : <b>' . $file . '</b></td><td align="right">Poids : <b>' . get_file_taille(get_file_size($dir.'/'.$file)) . '</b></td></tr>';
			$content .= '<tr><td align="center" colspan="2"><hr></td></tr>';
			$content .= '<tr><td align="center" colspan="2"><img src="' . $dir .'/'. $file . '" border="0"></td></tr>';
			$content .= '<tr><td align="center" colspan="2"><hr></td></tr>';
			$content .= '<tr><td align="center" colspan="2"><a href="' . $_SERVER['PHP_SELF'] . '">Retour</a></td></tr>';
			$content .= '</table>';
		}
		echo $content;
	}


	function NewDirForm() {
		$path = (isset($_GET['path']) ? $_GET['path'] : './');
		$mode = (isset($_GET['mode']) ? $_GET['mode'] : 'create');
		$content = '<table width="50%" align="center" border="0" cellcpacing="5" cellpadding="0" class="bloc">';
		$content .= '<form method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$content .= '<input type="hidden" name="action" value="make_dir">';
		$content .= '<input type="hidden" name="mode" value="' . $mode . '">';
		$content .= '<tr><td>Dossier : </td><td><input type="text" name="dir" value="' . $path . '"></td></tr>';
		$content .= '<tr><td colspan="2"><input type="submit" name="submit" value="Enregistrer"></td></tr>';
		$content .= '</form>';
		$content .= '</table>';

		echo $content;
	}

	function make_dir() {
		$dir = (isset($_POST['dir']) ? $_POST['dir'] : '');
		$mode = (isset($_GET['mode']) ? $_GET['mode'] : 'create');
		$ch ='';
		$tb_info = pathinfo($dir);
		if(strlen($tb_info['dirname']) > strlen($tb_info['basename'])) {
			$tb_dir = explode("/", $tb_info['dirname']);
		}
		else {
			$tb_dir = $tb_info['basename'];
		}
		if(is_array($tb_dir) && count($tb_dir) > 0) {
			$txt='';
			for($i=0;$i<count($tb_dir);$i++) {
				$dir = $ch . $tb_dir[$i];
				if(!is_dir($dir)) {
					if(mkdir($dir, 755)) {
						$txt .= "INFO : Création du dossier : " . $dir . "<br>";
						$ch .= $tb_dir[$i].'/';
					}
				}
				else {
					$txt .= "INFO : Dossier existant : " . $dir . "<br>";
					$ch .= $tb_dir[$i].'/';
				}
			}
			$ch .= $tb_info['basename'];
			if(!is_dir($ch)) {
				if (mkdir($ch, 755)) {
					$txt .= "INFO : création du dossier : " . $ch . "<br>";
				}
			}
			else {
				$txt .= "INFO : Dossier existant : " . $ch  . "<br>";
			}
		}
		else {
			if (mkdir($dir, 755)) {
				$txt = "INFO : Création du dossier : " . $tb_info['basename'];
			}
		}
		echo $txt . '<hr>';
		list_file(RACINE);
	}

	function UploadForm() {
		$content = '<table align="center" width="50%" border="0" cellspacing="5" cellpadding="0" class="bloc">';
		$content .= '<form enctype="multipart/form-data" method="post" action="' . $_SERVER['PHP_SELF'] . '">';
		$content .= '<input type="hidden" name="action" value="UploadFile">';
    	$content .= '<tr align="center">'; 
    	$content .= '<td colspan="2">Upload de fichier</td>';
    	$content .= '</tr>';
		$content .= '<tr>'; 
    	$content .= '<td width="50%" align="right">Chemin vers le dossier destination :<br>Les dossiers inexistants seront créés.</td>';
    	$content .= '<td width="50%"><input type="text" name="dir"></td>';
    	$content .= '</tr>';
    	$content .= '<tr>'; 
    	$content .= '<td width="50%" align="right">Fichier à  uploader :</td>';
    	$content .= '<td width="50%"><input type="file" name="upfile"></td>';
    	$content .= '</tr>';
    	$content .= '<tr>';
    	$content .= '<td colspan="2" align="center">';
		$content .= '<input type="submit" name="Submit" value="Upload !">';
		$content .= '</td>';
    	$content .= '</tr>';
		$content .= '</form>';
		$content .= '</table>';
		echo $content;
	}

	function UploadFile() {
		$dir = (isset($_POST['dir']) ? $_POST['dir'] : './');
		if(!is_dir($dir)) {
			make_dir($dir);
		}
		$filepath = $dir . '/' . basename($_FILES['upfile']['name']);
		if (move_uploaded_file($_FILES['upfile']['tmp_name'], $filepath)) {
 			echo valid_upload($_FILES['upfile']['error']);
		} 
		else {
			echo valid_upload($_FILES['upfile']['error']);	
		}
		list_file(RACINE);
	}

	function valid_upload($error) {
		$error = intval($error);
		switch($error) {
			case"0":
			$msg = "INFO : téléchargement effectué avec succès.";
		break;
			case"1":
			case"2":
			$msg = "ERREUR : Le fichier excède la taille autorisée.";
		break;
			case"3":
			$msg = "ERREUR : Le fichier n'a été que partiellement téléchargé";
		break;
			case"4":
			$msg = "ERREUR : Le champs est vide";
		break;
			case"6":
			$msg = "ERREUR : Dossier temporaire inexistant : écriture impossible";
		break;
		}
		return $msg . '<hr>';
}

	function delete() {
		echo "interdit";
		$d_path = (isset($_GET['dpath']) ? $_GET['dpath'] : '');
		$tb = pathinfo($d_path);
		if(is_file($tb['dirname'] . "/" . $tb['basename'])) {
			if(unlink($tb['dirname'] . "/" . $tb['basename'])) {
				$msg = "INFO : Fichier correctement supprimé.";
			}
			else {
				$msg = "ERREUR : Lors de la suppression du fichier.";
			}
		}
		if($tb['dirname'] != './') {
			$tab_contenu = traverse($tb['dirname'], 1);
			$nb_file = count($tab_contenu);
			if($nb_file > 0) {
				$msg .= "<br>INFO : Le dossier " . $tb['dirname'] . " n'est pas vide";
			}
			else {
				if(rmdir($tb['dirname'])) {
					$msg .= "<br>INFO : Le dossier " . $tb['dirname'] . " étant vide, il a été supprimé.";
				}
				else {
					$msg .= "<br>ERREUR : Le dossier " . $tb['dirname'] . " est vide, mais n'a pas été supprimé.";
				}
			}
		}
		echo $msg . '<hr>';
		list_file(RACINE);
	}




?>
