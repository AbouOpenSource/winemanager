<?php

$color_title='#B3B3B3';
$error_	 = 0;

if (isset($_POST['modifier_mdp'])) {
	
	$tab_compte_mod['mdp1']	= $_POST['mdp1'];
	$tab_compte_mod['mdp2']	= $_POST['mdp2'];
	$tab_compte_mod['mdp3']	= $_POST['mdp3'];
	
	$msg_=f_modification_compte_mdp($login, $tab_compte_mod);
	
	if ($msg_ == 'pb') { $error_ = 1; $msg_a_afficher = 'Changement de mdp annulé';}
	else {$msg_a_afficher = 'Changement de mdp effectué';}
}

// Validation d'une commande
if (isset($_POST['modifier_compte'])) {
	
	$v_nb_lignes_commande = str_replace("'","\'", $_POST['nb_lignes_commande']);
	if ($v_nb_lignes_commande >= 0 and $v_nb_lignes_commande <= 100 and f_test_int($v_nb_lignes_commande) == 1) { $v_nb_lignes_commande = $v_nb_lignes_commande; }
	else { $v_nb_lignes_commande = 20; }
	
	$tab_compte_mod['nom_tiers']			= str_replace("'","\'", $_POST['nom_tiers']);
	$tab_compte_mod['nom']					= str_replace("'","\'", $_POST['nom']);
	$tab_compte_mod['prenom']				= str_replace("'","\'", $_POST['prenom']);
	$tab_compte_mod['adresse1']				= str_replace("'","\'", $_POST['adresse1']);
	$tab_compte_mod['adresse2']				= str_replace("'","\'", $_POST['adresse2']);
	$tab_compte_mod['cp']					= str_replace("'","\'", $_POST['cp']);
	$tab_compte_mod['ville']				= str_replace("'","\'", $_POST['ville']);
	$tab_compte_mod['num_siret']			= str_replace("'","\'", $_POST['num_siret']);
	$tab_compte_mod['num_tva']				= str_replace("'","\'", $_POST['num_tva']);
	$tab_compte_mod['e_mail']				= str_replace("'","\'", $_POST['e_mail']);
	$tab_compte_mod['tel_fixe']				= str_replace("'","\'", $_POST['tel_fixe']);
	$tab_compte_mod['tel_mobile']			= str_replace("'","\'", $_POST['tel_mobile']);
	$tab_compte_mod['nb_lignes_commande']	= $v_nb_lignes_commande;
	$tab_compte_mod['pied_de_mail']			= str_replace("'","\'", $_POST['pied_de_mail']);
	
	f_modification_compte($login, $tab_compte_mod);
	
	$msg_a_afficher = 'Modification effectuée';
}

$tab_compte = f_affiche_compte($login);

$v_login				= $tab_compte[0];
$v_mdp					= $tab_compte[1];
$v_nom_tiers			= $tab_compte[2];
$v_nom					= $tab_compte[3];
$v_prenom				= $tab_compte[4];
$v_adresse1				= $tab_compte[5];
$v_adresse2				= $tab_compte[6];
$v_cp					= $tab_compte[7];
$v_ville				= $tab_compte[8];
$v_num_siret			= $tab_compte[9];
$v_num_tva				= $tab_compte[10];
$v_e_mail				= $tab_compte[11];
$v_tel_fixe				= $tab_compte[12];
$v_tel_mobile			= $tab_compte[13];
$v_dat_cre				= $tab_compte[14];
$v_dat_upd				= $tab_compte[15];
$v_flag_admin			= $tab_compte[16];
$v_dat_deb				= NormalDate($tab_compte[17]);
$v_dat_fin				= NormalDate($tab_compte[18]);
$v_nb_lignes_commande	= $tab_compte[19];
$v_pied_de_mail			= $tab_compte[20];

$v_dat_cre		= NormalDate_heure($v_dat_cre);
$v_dat_upd		= NormalDate_heure($v_dat_upd);

include('inc/wm_form_compte.php'); 


?>

