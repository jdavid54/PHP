<HTML>
	<HEAD>
		<TITLE>
		</TITLE>
	</HEAD>
	<BODY>

<font size=2 color=black">jfjsjkfmfhjqshfjkq<br>
<?php
// l'affichage sera : lefichier.txt a �t� modifi� le : December 29 2002 22:16:23.
$filename = 'essai.php';
if (file_exists($filename)) {
echo "$filename a �t� modifi� le : " . date ("F d Y H:i:s.", filemtime($filename));
}
?>
	</BODY>
</HTML>