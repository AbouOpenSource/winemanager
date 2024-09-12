
<table width=100% align=center border=0>
<tr>

<!-- AFFICHAGE DES n dernieres commandes -->
<td width=50% align=left valign=top>

<?php
$nb_commandes=15;

echo "<table width=90% style='border:1px solid $couleur_bordure'>";
echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
echo 'Liste des '. $nb_commandes . ' derni&egrave;res commandes saisies';
echo '</th>';
echo '<tr><td>';
f_affiche_n_dernieres_commandes($_SESSION['login'], $nb_commandes); 
echo '</td></tr>';
?>
</table>

</td>

<td width=50% valign=top>

<!-- AFFICHAGE DES N MEILLEURS CLIENTS -->
<?php
$nb_clients	= 5;
$nb_jours	= 30;
$date_debut	= date('Y-m-d', strtotime('-'.$nb_jours.' days'));

echo "<table width=90% style='border:1px solid $couleur_bordure'>";
echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
echo 'Liste des '. $nb_clients . ' meilleurs clients depuis le ' . NormalDate($date_debut) . ' (' . $nb_jours . ' derniers jours)' ;
echo '</th>';
echo '<tr><td>';
f_affiche_n_top_client_fournisseur_periode($_SESSION['login'], $nb_clients, $date_debut, 'C'); 
echo '</td></tr>';
?>
</table>
<br><br>

<!-- AFFICHAGE DES N MEILLEURS FOURNISSEURS -->
<?php
$nb_clients	= 5;
$nb_jours	= 30;
$date_debut	= date('Y-m-d', strtotime('-'.$nb_jours.' days'));

echo "<table width=90% style='border:1px solid $couleur_bordure'>";
echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
echo 'Liste des '. $nb_clients . ' meilleurs fournisseurs depuis le ' . NormalDate($date_debut) . ' (' . $nb_jours . ' derniers jours)' ;
echo '</th>';
echo '<tr><td>';
f_affiche_n_top_client_fournisseur_periode($_SESSION['login'], $nb_clients, $date_debut, 'F'); 
echo '</td></tr>';

?>
</table>

</td>
</tr>

<?php
if (f_retourne_nb_lignes_versionning($nb_jours, 'O') > 0) {
	echo '<tr><td colspan=2>';
	echo '<br>';
		echo "<table width=90% style='border:1px solid $couleur_bordure'>";
		echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
		echo 'Modifications apportees durant les ' . NormalDate($date_debut) . ' (' . $nb_jours . ' derniers jours)' ;
		echo '</th>';
		echo '<tr><td>';
		f_affiche_version ($nb_jours, 'O');
		echo '</td></tr>';
	echo '</td></tr>';
}
?>

</table>
