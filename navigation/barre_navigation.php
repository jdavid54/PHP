<?php

$tab_contenu = array();
/*
$pointeur = opendir('.');
echo $pointeur;
$file = readdir($pointeur);
echo $file;
$tab_contenu[] .= "$file";
*/

if ($pointeur = opendir('/var/www/html/')) {
	while (false !== ($file = readdir($pointeur))) {
		if ($file != "." && $file != "..") {
			//echo $file . "<br>";
			$tab_contenu[] .= "$file";
		}
	}
closedir($pointeur);
}
/*
for ($i=0;$i<count($tab_contenu);$i++) {
	echo $tab_contenu[$i] . "<br>";
}

while (list($key, $val) = each($tab_contenu)) {    // each obsolete from PHP 7.0
	echo $key . ' ' . $val . "<br>";
}

reset($tab_contenu);    // mandatory to set the pointer at the beginning

echo current($tab_contenu) . "<br>";
echo next($tab_contenu);
*/


function select_file($nom, $dossier='') {
	$dir = (strlen($dossier) > 0 ? $dossier : '.');
	if ($pointeur = opendir($dir)) {
		$select_file = '<form name="fileform" action="' . $_SERVER['PHP_SELF'] . '" method="post">';
		$select_file .= '<br><center><select name="' . $nom . '" OnChange="submit();">
						<option value ="" selected>Choisir un fichier</option>';
		while (false !== ($file = readdir($pointeur))) {
			if ($file != "." && $file != "..") {
				if (!is_dir($file)) {
					//echo $file;
					$select_file .= '<option value="' . $file . '">' . $file . '</option>';
				}
			}
		}
	}
	closedir($pointer);
	$select_file .= '</select></center></form>';

	return $select_file;

} //end function
/*
for ($i=0;$i<count($tab_contenu);$i++) {
	echo $tab_contenu[$i] . "<br>";
}
*/

$selected = (isset($_POST['file1']) ? $_POST['file1'] : '');

if (strlen($selected) > 0) {
	echo 'File selected : ' . $selected;
}
else {
	echo select_file('file1', '../');
}
?>