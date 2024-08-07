
<?php

if(isset($_GET['act_'])) { $act_=$_GET['act_']; } else { $act_='global_fournisseurs'; }
if(isset($_GET['annee_'])) { $annee_=$_GET['annee_']; } else { $annee_=date('Y'); }
if(isset($_GET['num_reporting_'])) { $num_reporting_=$_GET['num_reporting_']; } else { $num_reporting_=0; }

$url_title = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']  ;
if(strpos($url_title,'&annee=') > 0)  {$url_title = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI']  ;}
else {$url_title = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&annee_='.date('Y') ;}
$color_title='#B3B3B3';

// VARIABLES POUR LE FICHIER 
$error_				= 0;

echo '<table width=100%>';
echo '<tr>';
echo '<td>';
echo f_affiche_bouton_submit ('global_fournisseurs', 'Fournisseurs', 1, 'wm_accueil.php?menu_=n_a&stats_=stats&act_=global_fournisseurs&annee_='.$annee_);
echo f_affiche_bouton_submit ('global_clients', 'Clients', 2, 'wm_accueil.php?menu_=n_a&stats_=stats&act_=global_clients&annee_='.$annee_);
echo f_affiche_bouton_submit ('global', 'Global', 2, 'wm_accueil.php?menu_=n_a&stats_=stats&act_=global&annee_='.$annee_);
echo f_affiche_bouton_submit ('globalm', 'Mensuel', 2, 'wm_accueil.php?menu_=n_a&stats_=stats&act_=globalm&annee_='.$annee_);
echo f_affiche_bouton_submit ('reporting', 'Extraction', 2, 'wm_accueil.php?menu_=n_a&stats_=stats&act_=reporting&num_reporting_=0');
echo '<br><br>';
//echo f_affiche_bouton_submit ('annee_2014', '2014', 1, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2014');
//echo f_affiche_bouton_submit ('annee_2015', '2015', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2015');
//echo f_affiche_bouton_submit ('annee_2016', '2016', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2016');
echo f_affiche_bouton_submit ('annee_2017', '2017', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2017');
echo f_affiche_bouton_submit ('annee_2018', '2018', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2018');
echo f_affiche_bouton_submit ('annee_2019', '2019', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2019');
echo f_affiche_bouton_submit ('annee_2020', '2020', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2020');
echo f_affiche_bouton_submit ('annee_2021', '2021', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2021');
echo f_affiche_bouton_submit ('annee_2022', '2022', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2022');
echo f_affiche_bouton_submit ('annee_2023', '2023', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2023');
echo f_affiche_bouton_submit ('annee_2024', '2024', 2, substr($url_title, 0, strpos($url_title,'&annee_=')) . '&annee_=2024');

if ($act_ == 'global_fournisseurs') {
	echo f_affiche_bouton_submit ('progf', 'Progression', 2, 'wm_accueil.php?menu_=n_a&stats_=stats&act_=progf');
}
else {
	echo f_affiche_bouton_submit ('progc', 'Progression', 2, 'wm_accueil.php?menu_=n_a&stats_=stats&act_=progc');
}

echo '<br><br>';
echo '</td>';
echo '</tr>';

if ($act_ == 'reporting') {
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Extractions disponibles ';
	echo '</th>';
	echo '<tr><td>';
	
	f_affiche_tableau_reporting($login);
	
	if ($num_reporting_ > 0) { // Envoi du reporting
	
	f_gestion_envoi_reporting($login, $num_reporting_);
	
	$num_reporting_ = 0;
	}
		
	
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}

if ($act_ == 'global_fournisseurs') {
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Statistiques fournisseurs : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_stat_commande ($login, 'F', 'N', $annee_);
	f_affiche_stat_commande ($login, 'F', 'Y', $annee_);
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}

if ($act_ == 'global_clients') {
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Statistiques clientes : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_stat_commande ($login, 'C', 'N', $annee_);
	f_affiche_stat_commande ($login, 'C', 'Y', $annee_);
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}

if ($act_ == 'global') {
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Statistiques globales : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_stat_commande ($login, 'T', 'N', $annee_);
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}

if ($act_ == 'globalm') {
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Statistiques globales mensuelles : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_stat_commande ($login, 'TM', 'N', $annee_);
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}

if ($act_ == 'progf') {
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Progression mensuelles : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_stat_evolution ($login, 'F', 'N');
	f_affiche_stat_evolution ($login, 'F', 'Y');
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}

if ($act_ == 'progc') {
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Progression mensuelles : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_stat_evolution ($login, 'C', 'N');
	f_affiche_stat_evolution ($login, 'C', 'Y');
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}

echo '</td>';
echo '</tr>';
echo '</table>';
?>