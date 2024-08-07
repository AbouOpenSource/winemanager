<?php

$color_title='#B3B3B3';

// VARIABLES POUR LE FICHIER 
$flag_modifier		= 0;
$flag_afficher		= 0;
$flag_ajout			= 0;
$error_				= 0;

if(isset($_GET['num_commande']))	{ $num_commande=$_GET['num_commande']; }	else { $num_commande=0; }
if(isset($_GET['num_plv_']))		{ $num_plv_=$_GET['num_plv_']; }			else { $num_plv_=0; }
if(isset($_GET['num_plv_pdf']))		{ $num_plv_pdf=$_GET['num_plv_pdf']; }			else { $num_plv_pdf=0; }

// Gestion de l'envoi PLV
if ($num_plv_ > 0) {
	$style='style_form_1';
	$error_=f_envoi_plv ($num_plv_, $login, $color_title, $style);
}

// Generation de la commande en pdf
if ($num_plv_pdf > 0) {
	f_generate_commande_pdf_fournisseur($login, $num_commande, $color_title, 'style_form_1', $num_plv_pdf);
}

// Suppression d'une commande
if (isset($_POST['supprimer_commande'])) {
	f_annuler_commande($login, $num_commande);
	$num_commande=0;
}

// Validation d'une commande
if (isset($_POST['valider_commande'])) {
	f_valider_commande($login, $num_commande);
}

// Affichage du tableau des commandes
if ($num_commande == 0) {
$nb_commandes_en_cours = f_calcul_nb_commande_devis('C','E',$login);

echo '<table width=100%>';
echo '<tr><td>';

// Affichage du bouton Ajout commande
echo '<form method=post action=wm_accueil.php?menu_=n_a&action_=commande&num_commande=-1>';
echo f_affiche_bouton_submit ('ajouter_commande', 'Ajouter', 1, '');
echo f_affiche_bouton_submit ('affiche_toutes_commandes', 'Total', 2, 'wm_accueil.php?menu_=n_a&action_=commande&num_commande=-2');
echo '</form>';

echo '</td></tr>';

if ($nb_commandes_en_cours > 0) {
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Liste des '. $nb_commandes_en_cours . ' commandes en cours : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_liste_commande_devis('C','E',$login);
	echo '</td></tr>';
	echo '</table>';
	echo '</td></tr>';
}
echo '</table>';

}

if ($num_commande == -2) {
	// Affichage du tableau
	echo '<br>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Liste des commandes : ';
	echo '</th>';
	echo '<tr><td>';
	f_affiche_liste_commande_devis('C','T',$login);
	echo '</td></tr>';
	echo '</table>';
}

// Creation d'une commande
if ($num_commande == -1) {
	$num_commande=f_ajoute_commande_devis($login, 'C');
}

// Epuration d'une commande
if (isset($_POST['epurer_commande'])) {
	f_epurer_commande($login, $num_commande);
}

// Envoi de la commande au client
if (isset($_POST['envoyer_commande'])) {
	f_envoyer_commande_client($login, $num_commande, $color_title, 'style_form_1');
}

// Modification d'une commande
if (isset($_POST['modifier_commande'])) {

	$flag_modifier=1;
	include('inc/wm_form_stock_var_commande.php'); 
	$flag_modifier=0;
	f_modification_commande($login, $num_commande, $tab_com_client, $tab_commmande, $__NB_LIGNES_FORMULAIRES_COMMANDE, $tab_plv);
	$modifier_commande = 0;

}

// Affichage de la commande dans le formulaire
if ($num_commande > 0) {
	
	$verification_ = f_verifie_info_ok($login, 'Ce', $num_commande);
	
	// COMMANDE EXISTE
	if ($verification_ == 0) {
		$tab_commande_client_1 = f_affiche_commande_client_1($login, $num_commande);
		$tab_commande_client_2 = f_affiche_commande_client_2($login, $num_commande);
		$tab_commande_client_3 = f_affiche_commande_client_3($login, $num_commande);

		$flag_afficher=1;
		include('inc/wm_form_stock_var_commande.php'); 
		$flag_afficher=0;

		include('inc/wm_form_commande.php');
	}
	// COMMANDE N'EXISTE PAS --> modification de l'url à la main
	else {
		echo '<br>';
		echo '<table width=100%>';
		echo '<tr><td align=center class=style2>';
		echo "Cette commande n'existe pas : $num_commande.";
		echo '<br>';
		echo "Merci de ne pas modifier l'url dans l'application.";
		echo '</td></tr>';
		echo '</table>';
	}
}

?>