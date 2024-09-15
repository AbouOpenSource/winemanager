<?php

$color_title='#B3B3B3';
$error_	 = 0;

if(isset($_GET['compte_mod'])) { $compte_mod=$_GET['compte_mod']; } else { $compte_mod=''; }


if(isset($_POST['modifier_date'])) {
	$compte_mod						= str_replace("'","\'", $_POST['compte_mod']);
	$tab_compte_mod['v_dat_deb']	= str_replace("'","\'", $_POST['dat_deb']);
	$tab_compte_mod['v_dat_fin']	= str_replace("'","\'", $_POST['dat_fin']);
	
	f_modification_compte_date($compte_mod, $tab_compte_mod);
	
	$compte_mod='';
}

// Affichage du formulaire de date de début et fin pour un compte dans 1 formulaire
if ( $compte_mod != '' ) {
	
	$tab_compte = f_affiche_compte($compte_mod);
	$v_dat_deb	= $tab_compte[17];
	$v_dat_fin	= $tab_compte[18];
	
	echo '<form method=post action=wm_accueil.php?menu_=compte_liste>';
	echo '<table width=30%>';
	echo '<th bgcolor=#B3B3B3 class=style2 align=center> Login </th>';
	echo '<th bgcolor=#B3B3B3 class=style2 align=center> Date debut </th>';
	echo '<th bgcolor=#B3B3B3 class=style2 align=center> Date_fin </th>';
	echo '<th bgcolor=#B3B3B3 class=style2 align=center> Action </th>';
	echo '<tr>';
	echo '<td align=center> <input type=text class=style_form_1 name=compte_mod size=10 value='.$compte_mod.'> </td>';
	echo '<td align=center><input type=text class=style_form_1 name=dat_deb size=10 value='.$v_dat_deb.'></td>';
	echo '<td align=center><input type=text class=style_form_1 name=dat_fin size=10 value='.$v_dat_fin.'></td>';
	echo '<td class=style_form_1 align=center> '. f_affiche_bouton_submit ('modifier_date', 'Modifier', 0, '') . '</td>';
	echo '</tr>';
	echo '</table>';
	echo '<br>';
	
	echo '</form>';
}



// Affichage du tableau
echo "<table width=90% style='border:1px solid $couleur_bordure'>";
echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
echo 'Audit connexions des comptes : ';
echo '</th>';
echo '<tr><td>';
f_affiche_liste_comptes ($login);
echo '</td></tr>';
echo '</table>';

echo '<br><br><br>';

echo "<table width=90% style='border:1px solid $couleur_bordure'>";
echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
echo 'Volumétrie des comptes : ';
echo '</th>';
echo '<tr><td>';
f_affiche_indicateurs_utilisateurs ();
echo '</td></tr>';
echo '</table>';




?>

