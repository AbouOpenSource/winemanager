
<?php
$color_title='#B3B3B3'; 
$flag_modifier = 0;
$flag_afficher = 0;
$passage_1 = 0;
$flag_client_fournisseur = 'C';

if(isset($_GET['tab_com_tier'])) { $tab_com_tier=$_GET['tab_com_tier']; } else { $tab_com_tier=''; }
if(isset($_GET['tab_dev_tier'])) { $tab_dev_tier=$_GET['tab_dev_tier']; } else { $tab_dev_tier=''; }
if(isset($_GET['tab_rdv_tier'])) { $tab_rdv_tier=$_GET['tab_rdv_tier']; } else { $tab_rdv_tier=''; }
if(isset($_GET['id_client'])) { $id_client=$_GET['id_client']; } else { $id_client=0; }
if(isset($_GET['type_client_'])) { $type_client_=$_GET['type_client_']; } else { $type_client_='C'; }
if(isset($_GET['tab_produit'])) { $tab_produit=$_GET['tab_produit']; } else { $tab_produit=''; }
$error_ = 0;

f_modification_tiers_client_prospect($login);

// Suppression d'un client
if (isset($_POST['supprimer_client'])) {
 f_supprimer_client($login, $id_client);
 $tab_com_tier='';
 $tab_dev_tier='';
 $id_client=0;
}

// Affichage du tableau de toutes les commandes
if ( (isset($_POST['commandes_client']) or $tab_com_tier != '') ) {
	
	if ( !isset($_POST['ajouter_client']) and !isset($_POST['modifier_client']) and !isset($_POST['devis_client']) ) {
		
		f_affiche_liste_commande_devis_client($id_client, $login, 'C');
		$id_client=-2;
		$passage_1=1;
	}
}

// Affichage du tableau de tous les devis
if ( (isset($_POST['devis_client']) or $tab_dev_tier != '') ) {
	
	if ( $passage_1 == 0 and !isset($_POST['ajouter_client']) and !isset($_POST['modifier_client']) and !isset($_POST['commandes_client']) ) {

		f_affiche_liste_commande_devis_client($id_client, $login, 'D');
		$id_client=-2;
	}
}

// Affichage du tableau des clients
if ($id_client == 0) {
	$nb_clients = f_calcul_nb_tiers($login, 'C', $type_client_);

	$titre_tab = '';
	if ($type_client_ == 'C') {$titre_tab = ' clients : ';}
	if ($type_client_ == 'P') {$titre_tab = ' prospects : ';}
	
	echo '<table width=100%>';
	// Affichage du bouton afficher
	echo '<tr><td>';
	echo '<form method=post action=wm_accueil.php?menu_=n_a&tiers_=client&id_client=-1>';
	echo f_affiche_bouton_submit ('ajouter_client', 'Ajouter', 1, '');
	echo f_affiche_bouton_submit ('client', 'Clients', 2, 'wm_accueil.php?wm_accueil.php?menu_=n_a&tiers_=client&type_client_=C');
	echo f_affiche_bouton_submit ('prospect', 'Prospects', 2, 'wm_accueil.php?wm_accueil.php?menu_=n_a&tiers_=client&type_client_=P');
	//echo f_affiche_bouton_submit ('export', 'Export', 2, '');
	echo '</form>';
	echo '</td></tr>';
	// Affichage du tableau
	echo '<tr><td>';
	echo "<table width=90% style='border:1px solid $couleur_bordure'>";
	echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
	echo 'Liste des ' . $nb_clients . $titre_tab;
	echo '</th>';
	echo '<tr><td>';
	f_affiche_liste_client_fournisseurs($login, 'C', $type_client_);
	echo '</td></tr>';
	echo '</table>';

	echo '</td></tr>';
	echo '</table>';
}

// Export
if (isset($_POST['export'])) { 
	f_exporte_requete_excel($login);
}

// Creation d'un client
if (isset($_POST['ajouter_client'])) { 
	$id_client=f_ajoute_tiers($login, 'C');
}

// Modification d'un client
if (isset($_POST['modifier_client'])) {
	
	$flag_modifier=1;
	include('inc/wm_form_stock_var_client.php'); 
	$flag_modifier=0;

	if ( $error_ == 0 ) {
		f_modification_client($login, $id_client, $tab_client_mod);
	}
}

// Affichage du RDV
if ($tab_rdv_tier == 'Y') {
    include('inc/wm_rdv_client.php');
}

if ($tab_produit == 'Y') {
	include('inc/wm_stats_produits.php'); 
}

// Affichage du client selectionne dans tableau
if ($id_client > 0 and $tab_rdv_tier == '' and $tab_produit == '') {
	
	$verification_ = f_verifie_info_ok($login, 'Ct', $id_client);
	
	// CLIENT EXISTE
	if ($verification_ == 0) {
		$tab_client = f_affiche_client($login, $id_client);

		$flag_afficher=1;
		include('inc/wm_form_stock_var_client.php'); 
		$flag_afficher=0;

		include('inc/wm_form_client.php'); 
	}
	// CLIENT N'EXISTE PAS --> modification de l'url à la main
	else {
		echo '<br>';
		echo '<table width=100%>';
		echo '<tr><td align=center class=style2>';
		echo 'Ce client est inconnu : ' . $id_client . '.';
		echo '<br>';
		echo "Merci de ne pas modifier l'url dans l'application.";
		echo '</td></tr>';
		echo '</table>';
	}
}



?>

