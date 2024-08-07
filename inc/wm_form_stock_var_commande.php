<?php

// PARTIE COMMANDE --------------------------------------------------------------------------------
if ($flag_modifier == 1) {

if(isset($_POST['adr_livraison'])) { $adr_livraison=$_POST['adr_livraison']; } else { $adr_livraison = ''; }

$tab_com_client['nom_client']			= $_POST['nom_client'];
$tab_com_client['commande_date']		= mysqlDate($_POST['commande_date']);
$tab_com_client['type_commande']		= $_POST['type_commande'];
$tab_com_client['livraison_date']		= mysqlDate($_POST['livraison_date']);
$tab_com_client['livraison_h_debut']	= $_POST['livraison_h_debut'];
$tab_com_client['livraison_h_fin']		= $_POST['livraison_h_fin'];
$tab_com_client['commentaire']			= str_replace("'","\'", $_POST['commentaire']);
$tab_com_client['etat_commande']		= substr($_POST['etat_commande'], 0, 1);
$tab_com_client['adr_livraison_flag']	= $_POST['adr_livraison_flag'];
$tab_com_client['adr_livraison']		= str_replace("'","\'", $adr_livraison);

	for($i=1 ;$i <= $__NB_LIGNES_FORMULAIRES_COMMANDE; $i++) {
	
	$tab_commmande[$i]['nom_fournisseur']	= $_POST['nom_fournisseur_' . $i];
	$tab_commmande[$i]['produit']			= addslashes($_POST['produit_' . $i]);
	$tab_commmande[$i]['quantite']			= $_POST['quantite_' . $i];
	$tab_commmande[$i]['prix_ht']			= $_POST['prix_ht_' . $i];
	$tab_commmande[$i]['divers']			= $_POST['divers_' . $i];

	}
	
	$nb_lignes_plv = f_calcul_nb_plv_commande($num_commande, $login);
	
	for($i=1 ;$i <= $__NB_LIGNES_FORMULAIRES_COMMANDE; $i++) {
	
	if (isset($_POST['num_plv_' . $i])) {	$tab_plv[$i]['num_plv']	= $_POST['num_plv_' . $i];	} else {	$tab_plv[$i]['num_plv']	= 0;	}
	if (isset($_POST['plv_' . $i]))		{	$tab_plv[$i]['plv']		= $_POST['plv_' . $i];	} else {	$tab_plv[$i]['plv']		= '';	}
	
	}
	
}

if ($flag_afficher == 1) {

$nom_client			= $tab_commande_client_2['nom_client'];
$commande_date		= NormalDate($tab_commande_client_1['commande_date']);
$type_commande		= $tab_commande_client_1['type_commande'];
$livraison_date		= NormalDate($tab_commande_client_1['livraison_date']);
$livraison_h_debut	= $tab_commande_client_1['livraison_h_debut'];
$livraison_h_fin	= $tab_commande_client_1['livraison_h_fin'];
$commentaire		= $tab_commande_client_1['commentaire'];
$etat_commande		= $tab_commande_client_1['etat_commande'];
$date_modification	= $tab_commande_client_1['date_modification'];
$date_insertion		= $tab_commande_client_1['date_insertion'];
$adr_livraison_flag	= $tab_commande_client_1['livraison_adr_flag'];

if ($adr_livraison_flag == 'O') { $adr_livraison = trim($tab_commande_client_1['livraison_adr']); }
else 							{ $adr_livraison = ''; }

if ($etat_commande == 'E' ) {$etat_commande = 'En cours';}
if ($etat_commande == 'T' ) {$etat_commande = 'Terminée';}
if ($etat_commande == 'A' ) {$etat_commande = 'Annulée';}

$v_etat_commande = $etat_commande;

if ($livraison_date == '//' or $livraison_date == '00/00/0000') { $livraison_date = ''; }
if ($date_modification != '')  { $date_modification = 'modifié le ' . NormalDate_heure($date_modification); }
if ($date_insertion != '')  { $date_insertion = 'créé le ' . NormalDate_heure($date_insertion); }


}


?>

