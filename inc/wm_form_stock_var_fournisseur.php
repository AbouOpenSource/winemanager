<?php

// PARTIE COMMANDE --------------------------------------------------------------------------------
if ($flag_modifier == 1) {
	
	$error_ = 0;
	$error_nt = '';
	$error_m1 = '';
	$error_m2 = '';

	$nom_tiers		= addslashes(strtoupper(f_retourne_chaine_sans_accent($_POST['nom_tiers'])));
	$nom_tiers_code	= str_replace("'","", strtoupper(f_retourne_chaine_sans_accent($_POST['nom_tiers'])));
	$nom_tiers_code	= htmlspecialchars($nom_tiers_code);
	$mail_contact_1	= str_replace("'","\'", $_POST['mail_contact_1']);
	$mail_contact_1 = htmlspecialchars($mail_contact_1);
	$mail_contact_2	= str_replace("'","\'", $_POST['mail_contact_2']);
	$mail_contact_2 = htmlspecialchars($mail_contact_2);
	
	if (f_test_nom_tiers_doublon ($login, $nom_tiers_code, 'F', $id_client) > 0) {
		$nom_tiers_code	= 'A RENSEIGNER : CE FOURNISSEUR EXISTE';
		$nom_tiers		= 'A RENSEIGNER : CE FOURNISSEUR EXISTE';
	}
	
	if ($nom_tiers == '')		{ $nom_tiers = 'A RENSEIGNER'; }
	if ($nom_tiers_code == '')	{ $nom_tiers_code = 'A RENSEIGNER'; }
	
	$tab_client_mod['nom_tiers']			= $nom_tiers;
	$tab_client_mod['nom_tiers_code']		= $nom_tiers_code;
	$tab_client_mod['num_siret']			= htmlspecialchars(str_replace("'","\'", $_POST['num_siret']));
	$tab_client_mod['num_tva']				= htmlspecialchars(str_replace("'","\'", $_POST['num_tva']));
	$tab_client_mod['adr_livraison_1']		= str_replace("'","\'", $_POST['adr_livraison_1']);
	$tab_client_mod['adr_livraison_2']		= str_replace("'","\'", $_POST['adr_livraison_2']);
	$tab_client_mod['adr_livraison_cp']		= str_replace("'","\'", $_POST['adr_livraison_cp']);
	$tab_client_mod['adr_livraison_ville']	= str_replace("'","\'", $_POST['adr_livraison_ville']);
	$tab_client_mod['nom_contact_1']		= str_replace("'","\'", $_POST['nom_contact_1']);
	$tab_client_mod['nom_contact_2']		= str_replace("'","\'", $_POST['nom_contact_2']);
	$tab_client_mod['mail_contact_1']		= $mail_contact_1;
	$tab_client_mod['mail_contact_2']		= $mail_contact_2;
	$tab_client_mod['telephone_fixe']		= htmlspecialchars(str_replace("'","\'", $_POST['telephone_fixe']));
	$tab_client_mod['categorie']			= $_POST['categorie'];
	$tab_client_mod['commentaire']			= str_replace("'","\'", $_POST['commentaire']);
	$tab_client_mod['flag_envoi_pdf']		= $_POST['flag_envoi_pdf'];
	$tab_client_mod['flag_gestion_produit']	= $_POST['flag_gestion_produit'];
	
	if ( trim($nom_tiers) == '' or trim($nom_tiers) == 'A RENSEIGNER') { $error_ =  $error_ + 1; $error_nt = 'pb'; }
	if ( trim($mail_contact_1) != '' && f_verifie_mail($mail_contact_1) == 1 ) { $error_ =  $error_ + 1; $error_m1 = 'pb'; }
	if ( trim($mail_contact_2) != '' && f_verifie_mail($mail_contact_2) == 1 ) { $error_ =  $error_ + 1; $error_m2 = 'pb'; }

		
}

if ($flag_afficher == 1) {

	if(!isset($error_nt)) { $error_nt=''; }
	if(!isset($error_m1)) { $error_m1=''; }
	if(!isset($error_m2)) { $error_m2=''; }
	
	if ($error_nt != 'pb') { $nom_tiers			= $tab_client['nom_tiers'];			}		else { $nom_tiers		= 'pb' ;	}
	if ($error_m1 != 'pb') { $mail_contact_1	= $tab_client['mail_contact_1'];	}		else { $mail_contact_1	= 'pb' ;	}
	if ($error_m2 != 'pb') { $mail_contact_2	= $tab_client['mail_contact_2'];	}		else { $mail_contact_2	= 'pb' ;	}

	$nom_tiers				= htmlspecialchars($nom_tiers);
	$num_tiers				= $tab_client['num_tiers'];
	$num_siret				= $tab_client['num_siret'];
	$num_tva				= $tab_client['num_tva'];
	$adr_livraison_1		= $tab_client['adr_livraison_1'];
	$adr_livraison_2		= $tab_client['adr_livraison_2'];
	$adr_livraison_cp		= $tab_client['adr_livraison_cp'];
	$adr_livraison_ville	= $tab_client['adr_livraison_ville'];
	$nom_contact_1			= $tab_client['nom_contact_1'];
	$nom_contact_2			= $tab_client['nom_contact_2'];
	$telephone_fixe			= $tab_client['telephone_fixe'];
	$categorie				= $tab_client['categorie'];
	$flag_envoi_pdf			= $tab_client['flag_envoi_pdf'];
	$flag_gestion_produit	= $tab_client['flag_gestion_produit'];
	$commentaire			= $tab_client['commentaire'];
	$date_insertion			= 'créé le ' . NormalDate_heure($tab_client['date_insertion']);
	$date_modification		= 'modifié le ' . NormalDate_heure($tab_client['date_modification']);

	$annee = date('Y');
	$tab_res_stat = f_calcul_stat_commande_client ($num_tiers, 'F', $login, $annee);

	$v_rang					= $tab_res_stat[0];
	$v_num_tiers			= $tab_res_stat[1];
	$v_annee				= $annee;
	$v_ca					= $tab_res_stat[3] . ' €';
	$v_com					= $tab_res_stat[4] . ' €';
	$v_nb_bouteilles		= $tab_res_stat[5];
	$v_nb_commandes			= $tab_res_stat[6];
	$v_ca_moy_commande		= $tab_res_stat[7] . ' €';
	$v_com_moy_commande		= $tab_res_stat[8] . ' €';

}


?>

