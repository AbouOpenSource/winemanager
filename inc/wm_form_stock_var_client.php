<?php

// PARTIE COMMANDE --------------------------------------------------------------------------------
if ($flag_modifier == 1) {
	
	$error_ = 0;
	$error_nt = '';
	$error_m1 = '';
	$error_m2 = '';
	$error_m3 = '';
	$error_m4 = '';
	$error_m5 = '';
	
	$nom_tiers		= addslashes(strtoupper(f_retourne_chaine_sans_accent($_POST['nom_tiers'])));
	$nom_tiers_code	= str_replace("'","", strtoupper(f_retourne_chaine_sans_accent($_POST['nom_tiers'])));
	$nom_tiers_code	= htmlspecialchars($nom_tiers_code);
	$mail_contact_1 = str_replace("'","\'", $_POST['mail_contact_1']); 
	$mail_contact_2 = str_replace("'","\'", $_POST['mail_contact_2']); 
	$mail_contact_3 = str_replace("'","\'", $_POST['mail_contact_3']); 
	$mail_contact_4 = str_replace("'","\'", $_POST['mail_contact_4']); 
	$mail_contact_5 = str_replace("'","\'", $_POST['mail_contact_5']); 
	
	if (f_test_nom_tiers_doublon ($login, $nom_tiers_code, 'C', $id_client) > 0) {
		$nom_tiers_code	= 'A RENSEIGNER : CE CLIENT EXISTE';
		$nom_tiers		= 'A RENSEIGNER : CE CLIENT EXISTE';
	}
	
	if ($nom_tiers == '')		{ $nom_tiers = 'A RENSEIGNER'; }
	if ($nom_tiers_code == '')	{ $nom_tiers_code = 'A RENSEIGNER'; }
	
	if(isset($_POST['date_anniversaire'])) { $tab_client_mod['date_anniversaire']=$_POST['date_anniversaire']; } else { $tab_client_mod['date_anniversaire']=''; }
	if(isset($_POST['paiement_mode'])) { $tab_client_mod['paiement_mode']=$_POST['paiement_mode']; } else { $tab_client_mod['paiement_mode']=''; }
	
	$tab_client_mod['num_siret']				= htmlspecialchars(str_replace("'","\'", $_POST['num_siret']));
	$tab_client_mod['num_tva']					= htmlspecialchars(str_replace("'","\'", $_POST['num_tva']));
	$tab_client_mod['nom_tiers']				= $nom_tiers;
	$tab_client_mod['nom_tiers_code']			= $nom_tiers_code;
	$tab_client_mod['adr_livraison_1']			= str_replace("'","\'", $_POST['adr_livraison_1']);
	$tab_client_mod['adr_livraison_2']			= str_replace("'","\'", $_POST['adr_livraison_2']);
	$tab_client_mod['adr_livraison_cp']			= str_replace("'","\'", $_POST['adr_livraison_cp']);
	$tab_client_mod['adr_livraison_ville']		= str_replace("'","\'", $_POST['adr_livraison_ville']);
	$tab_client_mod['adr_facturation_1']		= str_replace("'","\'", $_POST['adr_facturation_1']);
	$tab_client_mod['adr_facturation_2']		= str_replace("'","\'", $_POST['adr_facturation_2']);
	$tab_client_mod['adr_facturation_cp']		= str_replace("'","\'", $_POST['adr_facturation_cp']);
	$tab_client_mod['adr_facturation_ville']	= str_replace("'","\'", $_POST['adr_facturation_ville']);
	$tab_client_mod['paiement_delai_j']			= str_replace("'","\'", $_POST['paiement_delai_j']);
	$tab_client_mod['nom_contact_1']			= str_replace("'","\'", $_POST['nom_contact_1']);
	$tab_client_mod['nom_contact_2']			= str_replace("'","\'", $_POST['nom_contact_2']);
	$tab_client_mod['nom_contact_3']			= str_replace("'","\'", $_POST['nom_contact_3']);
	$tab_client_mod['nom_contact_4']			= str_replace("'","\'", $_POST['nom_contact_4']);
	$tab_client_mod['nom_contact_5']			= str_replace("'","\'", $_POST['nom_contact_5']);
	$tab_client_mod['mail_contact_1']			= $mail_contact_1;
	$tab_client_mod['mail_contact_2']			= $mail_contact_2;
	$tab_client_mod['mail_contact_3']			= $mail_contact_3;
	$tab_client_mod['mail_contact_4']			= $mail_contact_4;
	$tab_client_mod['mail_contact_5']			= $mail_contact_5;
	$tab_client_mod['telephone_livraison']		= str_replace("'","\'", $_POST['telephone_livraison']);
	$tab_client_mod['telephone_portable']		= str_replace("'","\'", $_POST['telephone_portable']);
	$tab_client_mod['telephone_fixe']			= str_replace("'","\'", $_POST['telephone_fixe']);
	$tab_client_mod['categorie']				= $_POST['categorie'];
	$tab_client_mod['commentaire']				= str_replace("'","\'", $_POST['commentaire']);
	
	if ( trim($nom_tiers) == '' ) { $error_ =  $error_ + 1; $error_nt = 'pb'; }
	if ( trim($mail_contact_1) != '' && f_verifie_mail($mail_contact_1) == 1 ) { $error_ =  $error_ + 1; $error_m1 = 'pb'; }
	if ( trim($mail_contact_2) != '' && f_verifie_mail($mail_contact_2) == 1 ) { $error_ =  $error_ + 1; $error_m2 = 'pb'; }
	if ( trim($mail_contact_3) != '' && f_verifie_mail($mail_contact_3) == 1 ) { $error_ =  $error_ + 1; $error_m3 = 'pb'; }
	if ( trim($mail_contact_4) != '' && f_verifie_mail($mail_contact_4) == 1 ) { $error_ =  $error_ + 1; $error_m4 = 'pb'; }
	if ( trim($mail_contact_5) != '' && f_verifie_mail($mail_contact_5) == 1 ) { $error_ =  $error_ + 1; $error_m5 = 'pb'; }
		
}

if ($flag_afficher == 1) {

	if(!isset($error_nt)) { $error_nt=''; }
	if(!isset($error_m1)) { $error_m1=''; }
	if(!isset($error_m2)) { $error_m2=''; }
	if(!isset($error_m3)) { $error_m3=''; }
	if(!isset($error_m4)) { $error_m4=''; }
	if(!isset($error_m5)) { $error_m5=''; }
	
	if ($error_nt != 'pb') { $nom_tiers			= $tab_client['nom_tiers'];			}		else { $nom_tiers		= '' ;		}
	if ($error_m1 != 'pb') { $mail_contact_1	= $tab_client['mail_contact_1'];	}		else { $mail_contact_1	= 'pb' ;	}
	if ($error_m2 != 'pb') { $mail_contact_2	= $tab_client['mail_contact_2'];	}		else { $mail_contact_2	= 'pb' ;	}
	if ($error_m3 != 'pb') { $mail_contact_3	= $tab_client['mail_contact_3'];	}		else { $mail_contact_3	= 'pb' ;	}
	if ($error_m4 != 'pb') { $mail_contact_4	= $tab_client['mail_contact_4'];	}		else { $mail_contact_4	= 'pb' ;	}
	if ($error_m5 != 'pb') { $mail_contact_5	= $tab_client['mail_contact_5'];	}		else { $mail_contact_5	= 'pb' ;	}

	$nom_tiers				= htmlspecialchars($nom_tiers);
	$num_tiers				= $tab_client['num_tiers'];
	$num_siret				= $tab_client['num_siret'];
	$num_tva				= $tab_client['num_tva'];
	$adr_livraison_1		= $tab_client['adr_livraison_1'];
	$adr_livraison_2		= $tab_client['adr_livraison_2'];
	$adr_livraison_cp		= $tab_client['adr_livraison_cp'];
	$adr_livraison_ville	= $tab_client['adr_livraison_ville'];
	$adr_facturation_1		= $tab_client['adr_facturation_1'];
	$adr_facturation_2		= $tab_client['adr_facturation_2'];
	$adr_facturation_cp		= $tab_client['adr_facturation_cp'];
	$adr_facturation_ville	= $tab_client['adr_facturation_ville'];
	$paiement_mode			= $tab_client['paiement_mode'];
	$paiement_delai_j		= $tab_client['paiement_delai_j'];
	$nom_contact_1			= $tab_client['nom_contact_1'];
	$nom_contact_2			= $tab_client['nom_contact_2'];
	$nom_contact_3			= $tab_client['nom_contact_3'];
	$nom_contact_4			= $tab_client['nom_contact_4'];
	$nom_contact_5			= $tab_client['nom_contact_5'];
	$telephone_livraison	= $tab_client['telephone_livraison'];
	$telephone_portable		= $tab_client['telephone_portable'];
	$telephone_fixe			= $tab_client['telephone_fixe'];
	$flag_client_prospect	= $tab_client['flag_client_prospect'];
	$date_anniversaire		= NormalDate($tab_client['date_anniversaire']);
	$date_insertion			= 'créé le ' . NormalDate_heure($tab_client['date_insertion']);
	$date_modification		= 'modifié le ' . NormalDate_heure($tab_client['date_modification']);
	$categorie				= $tab_client['categorie'];
	$commentaire			= $tab_client['commentaire'];
	
	if ($date_anniversaire == '//' or $date_anniversaire == '00/00/0000') { $date_anniversaire = ''; }
	
	$annee = date('Y');
	$tab_res_stat = f_calcul_stat_commande_client ($id_client, 'C', $login, $annee);

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

