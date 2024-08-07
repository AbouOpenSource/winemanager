
<?php
$color_title='#B3B3B3'; 
// VARIABLES POUR LE FICHIER 
$flag_modifier		= 0;
$flag_afficher		= 0;
$error_				= 0;
$flag_client_fournisseur = 'F';

if(isset($_GET['id_client']))    { $id_client=$_GET['id_client'];       }  else { $id_client=0; }
if(isset($_GET['tab_com_tier'])) { $tab_com_tier=$_GET['tab_com_tier']; }  else { $tab_com_tier=''; }
if(isset($_GET['tab_produit']))  { $tab_produit=$_GET['tab_produit'];   }  else { $tab_produit=''; }
if(isset($_GET['form_produit'])) { $form_produit=$_GET['form_produit'];  }  else { $form_produit=''; }

if (isset($_POST['supprimer_client'])) {
 f_supprimer_client($login, $id_client);
 $tab_com_tier='';
 $id_client=0;
}

// Affichage du tableau des commandes terminees
if ( (isset($_POST['commandes_fournisseur']) or $tab_com_tier != '') ) {
   
    if ( !isset($_POST['modifier_fournisseur']) ) {
       
        f_affiche_liste_commande_fournisseurs($id_client, $login);
        $id_client=-2;
    }
}

// Affichage du tableau des fournisseurs
if ($id_client == 0) {
$nb_clients = f_calcul_nb_tiers($login, 'F');

echo '<table width=100%>';
// Affichage du bouton afficher
echo '<tr><td>';
echo '<form method=post action=wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client=-1>';
echo f_affiche_bouton_submit ('ajouter_fournisseur', 'Ajouter', 1, '');
echo '</form>';
echo '</td></tr>';
// Affichage du tableau
echo '<tr><td>';
echo "<table width=90% style='border:1px solid $couleur_bordure'>";
echo "<th bgcolor=$couleur_fond_entete class=style2 align=left style='border:1px solid $couleur_bordure'>";
echo 'Liste des '. $nb_clients . ' fournisseurs : ';
echo '</th>';
echo '<tr><td>';
f_affiche_liste_client_fournisseurs($login, 'F');
echo '</td></tr>';
echo '</table>';

echo '</td></tr>';
echo '</table>';
}

// Creation du fournisseur 
if ($id_client == -1) {

	$num_tiers = '';
	$num_siret = '';
	$num_tva = '';
	$nom_tiers = '';
	$adr_livraison_1= '';
	$adr_livraison_2= '';
	$adr_livraison_cp= '';
	$adr_livraison_ville= '';
	$nom_contact_1= '';
	$nom_contact_2= '';
	$mail_contact_1= '';
	$mail_contact_2= '';
	$telephone_fixe= '';
	$date_insertion= '';
	$date_modification= '';

	$id_client=f_ajoute_tiers($login, 'F');

}

// Modification du fournisseur
if (isset($_POST['modifier_fournisseur'])) {

	$flag_modifier=1;
	include('inc/wm_form_stock_var_fournisseur.php'); 
	$flag_modifier=0;

	if ( $error_ == 0 ) {
		f_modification_fournisseur($login, $id_client, $tab_client_mod);
	}
	
}

if ($tab_produit == 'Y') {
	include('inc/wm_stats_produits.php'); 
}

if ($form_produit == 'Y') {
	include('inc/wm_produit.php'); 
}

// Affichage du fournisseur selectionne dans tableau
if ($id_client > 0 and $tab_produit == '' and $form_produit == '') {
	
	$verification_ = f_verifie_info_ok($login, 'Fr', $id_client);
	
	// FOURNISSEUR EXISTE
	if ($verification_ == 0) {
		$tab_client = f_affiche_fournisseur($login, $id_client);

		$flag_afficher=1;
		include('inc/wm_form_stock_var_fournisseur.php'); 
		$flag_afficher=0;

		include('inc/wm_form_fournisseur.php'); 
	}
	// FOURNISSEUR N'EXISTE PAS --> modification de l'url à la main
	else {
		echo '<br>';
		echo '<table width=100%>';
		echo '<tr><td align=center class=style2>';
		echo 'Ce fournisseur est inconnu : ' . $id_client . '.';
		echo '<br>';
		echo "Merci de ne pas modifier l'url dans l'application.";
		echo '</td></tr>';
		echo '</table>';
	}
}



?>

