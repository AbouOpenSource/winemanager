<?php

$color_title='#B3B3B3';

echo '<table width=100%>';
echo '<tr>';
echo '<td>';

	echo '<br>';

	// Affichage du tableau
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Vos RDV : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_calendrier($login);
	echo '</td></tr>';
	echo '</table>';

echo '</td>';
echo '</tr>';
echo '</table>';

?>