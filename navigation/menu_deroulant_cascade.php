<?php

$tb_marques = array(0=>'Renault', 1=>'Peugeot', 2=> 'Citroën', 3=> 'Ford', 4=> 'Fiat', 5=> 'Nissan');

$tb_models = array(0=>array(0=>'Laguna', 1=>'Mégane', 2=> 'Espace', 3=> 'Velsatis'),
1=>array(0=>'206 CC', 1=>'307 CC', 2=> '607', 3=> '806'),
2=>array(0=>'C2 Pluriel', 1=>'C3', 2=> 'C4', 3=> 'Xara Picasso'),
3=>array(0=>'Ka', 1=>'Street Ka', 2=> 'Fiesta', 3=> 'Escort', 4=> 'Mondeo'),
4=>array(0=>'Uno', 1=>'Punto', 2=> 'Croma', 3=> 'Multiplat'),
5=>array(0=>'Micra', 1=>'Primera', 2=> 'Patrol GR' ));

$tb_options = array(
//Renault
0=>array(0=>array('Noir', 'Blanc', 'Bleu nuit'), 
1=>array('Vert bouteille', 'Blanc'), 
2=>array('Gris métal', 'Noir', 'Blanche', 'Bleu nuit'), 
3=> array('Aubergine', 'Gris métalisé', 'Noir','Blanc')), 
//Peugeot
1=>array(0=>array('Vert bouteille', 'Noir', 'Blanche', 'Bleu nuit', 'Aubergine'), 
1=>array('Aubergine','Vert bouteille', 'Noir', 'Blanc', 'Bordeaux'), 
2=>array('Rouge', 'Noir', 'Blanche', 'Bleu nuit'), 
3=> array('Aubergine', 'Gris métalisé', 'Noir','Blanc')), 
// Citroën
2=>array(0=>array('Noir', 'Blanc', 'Bleu nuit'), 
1=>array('Vet bouteille', 'Blanc'), 
2=>array('Gris métal', 'Noir', 'Blanche', 'Bleu nuit'), 
3=> array('Aubergine', 'Gris métalisé', 'Noir','Blanc')), 
//Ford
3=>array(0=>array('Noir', 'Blanc', 'Bleu nuit'), 
1=>array('Vert bouteille', 'Blanc'), 
2=>array('Gris métal', 'Noir', 'Blanche', 'Bleu nuit'), 
3=> array('Aubergine', 'Gris métalisé', 'Noir','Blanc'), 
4=> array('Gris métalisé', 'Noir','Blanc')), 
//Fiat
4=>array(0=>array('Noir', 'Blanc', 'Bleu nuit'), 
1=>array('Vet bouteille', 'Blanc'), 
2=>array('Gris métal', 'Noir', 'Blanche', 'Bleu nuit'), 
3=> array('Aubergine', 'Gris métalisé', 'Noir','Blanc')), 
//Nissan
5=>array(0=>array('Rouge', 'Noir', 'Blanc', 'Bleu nuit'), 
1=>array('Vert bouteille', 'Blanc', 'Bleu nuit'), 
2=>array('Gris métal', 'Noir', 'Blanc'))); 

$marque = (isset($_POST['marque']) ? $_POST['marque'] : '');
$model = (isset($_POST['model']) ? $_POST['model'] : '');
$couleur = (isset($_POST['couleur']) ? $_POST['couleur'] : '');

//echo $tb_marques[0];

// menu deroulant 1
$listing = '<form name="car_form" action="' . $_SERVER['PHP_SELF'] . '" method="post">';
$listing .= '<select name="marque" OnChange="submit();">
						<option value="">Choisir une marque</option>';
for ($i=0;$i<count($tb_marques);$i++) {
	$listing .= '<option value="' . $i . '"'
	. (strlen($marque) > 0 && $marque == $i ? ' selected' : '') . '>' . $tb_marques[$i] . '</option>';
}
$listing .= '</select>';

if (strlen($marque) > 0) {
	// menu deroulant 2
	$listing .= '<select name="model" OnChange="submit();">
						<option value ="">Choisir un modèle</option>';
	for ($j=0;$j<count($tb_models[$marque]);$j++) {
		$listing .= '<option value="' . $j . '"'
		. (strlen($model) > 0 && $model == $j ? ' selected' : '') . '>' . $tb_models[$marque][$j] . '</option>';
	}
	$listing .= '</select>';
}

if (strlen($marque) > 0 && strlen($model) > 0) {
	// menu deroulant 3
	$listing .= '<select name="couleur" OnChange="submit();">
						<option value ="">Choisir une couleur</option>';
	for ($k=0;$k<count($tb_options[$marque][$model]);$k++) {
		$listing .= '<option value="' . $k . '"'
		. (strlen($couleur) > 0 && $couleur == $k ? ' selected' : '') . '>' . $tb_options[$marque][$model][$k] . '</option>';
	}
	$listing .= '</select>';
}


$listing .= '</form>';



echo $listing;
echo $marque;
echo $model;
echo $couleur;



?>