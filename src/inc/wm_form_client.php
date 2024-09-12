<?php
if(isset($_GET['error_nt'])) { $error_nt=$_GET['error_nt']; } else { $error_nt=''; }
if(isset($_GET['error_m1'])) { $error_m1=$_GET['error_m1']; } else { $error_m1=''; }
if(isset($_GET['error_m2'])) { $error_m2=$_GET['error_m2']; } else { $error_m2=''; }
if(isset($_GET['error_m3'])) { $error_m2=$_GET['error_m3']; } else { $error_m3=''; }
if(isset($_GET['error_m3'])) { $error_m2=$_GET['error_m4']; } else { $error_m4=''; }
if(isset($_GET['error_m5'])) { $error_m2=$_GET['error_m5']; } else { $error_m5=''; }

$prochain_rdv	= f_retourne_prochain_rdv_client($login, $id_client);
$dernier_rdv	= f_retourne_date_dernier_rdv_client($login, $id_client);

if ($flag_client_prospect == 'C') { $titre_client_prospect = 'CLIENT : ' . $nom_tiers; } else { $titre_client_prospect = 'PROSPECT : ' . $nom_tiers; }
?>

<table width=100% cellpadding=0 align=center border=0 class=style_form_1>

<form method=post action=wm_accueil.php?menu_=n_a&tiers_=client&id_client=<?php echo $id_client; ?>&tab_com_tier=C&tab_dev_tier=D>

<!-- AFFICHAGE DES BOUTONS -->
<tr>
<td>
<?php
echo f_affiche_bouton_submit ('modifier_client', 'Enregistrer', 1, '');
echo f_affiche_bouton_submit ('supprimer_client', 'Supprimer', 2, '');
echo f_affiche_bouton_submit ('commandes_client', 'Commandes', 2, 'wm_accueil.php?menu_=n_a&tiers_=client&id_client='.$id_client.'&tab_com_tier=C');
echo f_affiche_bouton_submit ('devis_client', 'Devis', 2, 'wm_accueil.php?menu_=n_a&tiers_=client&id_client='.$id_client.'&tab_dev_tier=D');
echo f_affiche_bouton_submit ('rdv_client', 'RDV', 2, 'wm_accueil.php?menu_=n_a&tiers_=client&id_client='.$id_client.'&tab_rdv_tier=Y');
echo f_affiche_bouton_submit ('tab_produit', 'Produits', 2, 'wm_accueil.php?menu_=n_a&tiers_=client&id_client='.$id_client.'&tab_produit=Y');

?>
<br><br>
</td>

<!-- AFFICHAGE DU TEXTE X MS --> 
<td>
<?php  if ($error_ > 0) { 
 f_affiche_texte_n_sec (10000, 'Problème : cf formulaire', 'nok');
 }
 else if ($error_ == 0 and isset($_POST['modifier_client'])) { 
 f_affiche_texte_n_sec (5000, 'Modification effectu&eacute;e','ok');
 }
 ?>
</td>
</tr>

<!-- DEBUT DU FORMULAIRE --------------------------------------------------->

<!-- TITRE DU FORMULAIRE -->
<tr valign=center>
<?php 
if ( $nom_tiers == '' ) { ?> 
<td colspan=2 class=titre2 bgcolor=<?php  echo $color_title; ?> align=left> CREATION NOUVEAU CLIENT </td>
<?php  
}
else { ?>
<td colspan=2 class=titre2 bgcolor=<?php  echo $color_title; ?> align=left> <?php  echo $titre_client_prospect; ?> 
<span class=style_form_1> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php  echo $date_insertion; ?> </span>
</td>
<?php } ?>
</tr>

<tr>
<td colspan=2> <br> </td>
</tr>

<tr>
<td width=80%>
<!-- FORMULAIRE ----------------------------------->
<table border=0 width=100%>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Id Client &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=num_client size=45 disabled=disabled value="<?php  echo $id_client; ?>"> </td>
<td> <?php echo $date_modification; ?> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> Type &nbsp;&nbsp;</td>
<td> 
<input type=radio class=style_form_1 name=flag_client_prospect disabled=disabled value='C' <?php  if ($flag_client_prospect == 'C') { echo 'checked'; } ?>> CLIENT
<input type=radio class=style_form_1 name=flag_client_prospect disabled=disabled value='P' <?php  if ($flag_client_prospect == 'P') { echo 'checked'; } ?>> PROSPECT
</td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Nom &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=nom_tiers size=45 value="<?php  echo $nom_tiers; ?>"> </td>
<td> <br> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> SIRET &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=num_siret size=25 value="<?php  echo $num_siret; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Categorie &nbsp;&nbsp;</td>
<td> <select input type=text class=style_form_1 name=categorie  style='width: 250px; height: 20px;'> 
<option> <?php echo $categorie; ?> </option>
<option> Brasserie </option>
<option> Caviste </option>
<option> Club </option>
<option> Entreprise </option>
<option> Grossiste </option>
<option> Particulier </option>
<option> Restaurant </option> </select>
</td>
<td> <br> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> TVA &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=num_tva size=25 value="<?php  echo $num_tva; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right height=22> Dernier RDV &nbsp;&nbsp;</td>
<td> <?php  echo $dernier_rdv ?> </td>
<td colspan=3> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right height=22> Prochain RDV &nbsp;&nbsp;</td>
<td> <?php  echo $prochain_rdv ?> </td>
<td colspan=3> <br> </td>
</tr>


<tr>
<td colspan=6> <br> </td>
</tr>

<tr>
<td height=20> <br> </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> Adresse Livraison </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> Adresse Facturation </td>
<td> <br> </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> Info Paiement </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Rue &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=adr_livraison_1 size=45 value="<?php  echo $adr_livraison_1; ?>"> </td>
<td> <input type=text class=style_form_1 name=adr_facturation_1 size=45 value="<?php  echo $adr_facturation_1; ?>"> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> Mode de Paiement  &nbsp;&nbsp;</td>
<td>  
<input type=radio class=style_form_1 name=paiement_mode value='V' <?php  if ($paiement_mode == 'V') { echo 'checked'; } ?>> Virement
<input type=radio class=style_form_1 name=paiement_mode value='C' <?php  if ($paiement_mode == 'C') { echo 'checked'; } ?>> Cheque
<input type=radio class=style_form_1 name=paiement_mode value='P' <?php  if ($paiement_mode == 'P') { echo 'checked'; } ?>> Prelevement
</td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?>> <br> </td>
<td> <input type=text class=style_form_1 name=adr_livraison_2 size=45 value="<?php  echo $adr_livraison_2; ?>"> </td>
<td> <input type=text class=style_form_1 name=adr_facturation_2 size=45 value="<?php  echo $adr_facturation_2; ?>"> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> D&eacute;lai de Paiement &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=paiement_delai_j size=25 value="<?php  echo $paiement_delai_j; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> CP &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=adr_livraison_cp size=45 value="<?php  echo $adr_livraison_cp; ?>"> </td>
<td> <input type=text class=style_form_1 name=adr_facturation_cp size=45 value="<?php  echo $adr_facturation_cp; ?>"> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> Date anniversaire &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=date_anniversaire size=25 value="<?php  echo $date_anniversaire; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Ville &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=adr_livraison_ville size=45 value="<?php  echo $adr_livraison_ville; ?>"> </td>
<td colspan=3> <input type=text class=style_form_1 name=adr_facturation_ville size=45 value="<?php  echo $adr_facturation_ville; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Tel Livraison &nbsp;&nbsp; </td>
<td colspan=4> <input type=text class=style_form_1 name=telephone_livraison size=45 value="<?php  echo $telephone_livraison; ?>"> </td>
</tr>

<tr>
<td colspan=6> <br> </td>
</tr>

<tr>
<td colspan=6>


<table border=0> 
<tr>
<td height=20> <br> </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> Nom Pr&eacute;nom </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> Mail </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> T&eacute;l&eacute;phone Fixe </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> T&eacute;l&eacute;phone Portable </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Contact 1 &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=nom_contact_1 size=45 value="<?php  echo $nom_contact_1; ?>"> </td>
<td> 
<?php  if ( $mail_contact_1 == 'pb' ) { ?>
<input type=text class=style_form_2 name=mail_contact_1 size=45 value="<?php  echo $mail_contact_1; ?>">
<?php  
}
   else { ?>
<input type=text class=style_form_1 name=mail_contact_1 size=45 value="<?php  echo $mail_contact_1; ?>">
<?php  } ?>
</td>
<td> <input type=text class=style_form_1 name=telephone_fixe size=20 value="<?php  echo $telephone_fixe; ?>"> </td>
<td> <input type=text class=style_form_1 name=telephone_portable size=20 value="<?php  echo $telephone_portable; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Contact 2 &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=nom_contact_2 size=45 value="<?php  echo $nom_contact_2; ?>"> </td>
<td> 
<?php  if ( $mail_contact_2 == 'pb' ) { ?>
<input type=text class=style_form_2 name=mail_contact_2 size=45 value="<?php  echo $mail_contact_2; ?>">
<?php  
}
   else { ?>
<input type=text class=style_form_1 name=mail_contact_2 size=45 value="<?php  echo $mail_contact_2; ?>">
<?php  } ?>

</td>
<td> <br> </td>
<td> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Contact 3 &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=nom_contact_3 size=45 value="<?php  echo $nom_contact_3; ?>"> </td>
<td> 
<?php  if ( $mail_contact_3 == 'pb' ) { ?>
<input type=text class=style_form_2 name=mail_contact_3 size=45 value="<?php  echo $mail_contact_3; ?>">
<?php  
}
   else { ?>
<input type=text class=style_form_1 name=mail_contact_3 size=45 value="<?php  echo $mail_contact_3; ?>">
<?php  } ?> 
</td>
<td> <br> </td>
<td> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Contact 4 &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=nom_contact_4 size=45 value="<?php  echo $nom_contact_4; ?>"> </td>
<td> 
<?php  if ( $mail_contact_4 == 'pb' ) { ?>
<input type=text class=style_form_2 name=mail_contact_4 size=45 value="<?php  echo $mail_contact_4; ?>">
<?php  
}
   else { ?>
<input type=text class=style_form_1 name=mail_contact_4 size=45 value="<?php  echo $mail_contact_4; ?>">
<?php  } ?> 
</td>
<td> <br> </td>
<td> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Contact 5 &nbsp;&nbsp; </td>
<td> <input type=text class=style_form_1 name=nom_contact_5 size=45 value="<?php  echo $nom_contact_5; ?>"> </td>
<td> 
<?php  if ( $mail_contact_5 == 'pb' ) { ?>
<input type=text class=style_form_2 name=mail_contact_5 size=45 value="<?php  echo $mail_contact_5; ?>">
<?php  
}
   else { ?>
<input type=text class=style_form_1 name=mail_contact_5 size=45 value="<?php  echo $mail_contact_5; ?>">
<?php  } ?>
</td>
<td> <br> </td>
<td> <br> </td>
</tr>

</table>
</td></tr>

<tr>
<td colspan=6 bgcolor=<?php  echo $color_title; ?> align=left height=20> &nbsp;&nbsp; Commentaire </td>
</tr>

<tr>
<td colspan=6> <textarea class=style_form_1 name=commentaire rows=10 cols=180><?php echo $commentaire; ?></textarea> </td>
</tr>

<tr>
<td colspan=6> <br> </td>
</tr>
</table>
<!-- FIN DU FORMULAIRE ---------------------------->
</td>

<td valign=top width=20%>
<!-- STATS ---------------------------------------->
<?php if($flag_client_prospect == 'C') { ?>
<table width=100%>
<tr><td>
<table class=style_form_1 width=95% align=right>
<tr> <td class=style_form_3 bgcolor=<?php  echo $color_title; ?> align=center colspan=2>STATS <?php  echo $v_annee; ?> </td> </tr>
<tr> <td bgcolor=<?php  echo $color_title; ?> align=right width=60%> Rang &nbsp;</td> <td align=right width=40%> <?php  echo $v_rang; ?> </td> </tr>
<tr> <td bgcolor=<?php  echo $color_title; ?> align=right> Comm. &nbsp;</td> <td align=right> <?php  echo $v_com; ?> </td> </tr>
<tr> <td bgcolor=<?php  echo $color_title; ?> align=right> CA &nbsp;</td> <td align=right> <?php  echo $v_ca; ?> </td> </tr>
<tr> <td bgcolor=<?php  echo $color_title; ?> align=right> Comm. moyenne &nbsp;</td> <td align=right> <?php  echo $v_com_moy_commande; ?> </td> </tr>
<tr> <td bgcolor=<?php  echo $color_title; ?> align=right> Panier moyen &nbsp;</td> <td align=right> <?php  echo $v_ca_moy_commande; ?> </td> </tr>
<tr> <td bgcolor=<?php  echo $color_title; ?> align=right> Nb commandes &nbsp;</td> <td align=right> <?php  echo $v_nb_commandes; ?> </td> </tr>
<tr> <td bgcolor=<?php  echo $color_title; ?> align=right> Nb bouteilles &nbsp;</td> <td align=right> <?php  echo $v_nb_bouteilles; ?> </td> </tr>
</table>
</td></tr>

<tr><td colspan=2> <br> </td></tr>

<tr><td>
<table class=style_form_1 width=95% align=right>
<tr><td class=style_form_3 align=center colspan=2 bgcolor=<?php  echo $color_title; ?>> TOP <?php $n=3; echo $n; ?> </td>
<tr> <td> <?php  f_affiche_top_client_fournisseurs ($login, $id_client, 'C', $n, $v_annee); ?> </td> </tr>
</table>
</td></tr>
</table>
<?php } else { echo '<br>'; } ?>

<!-- FIN STATS ------------------------------------>

</td>
</tr>

<tr>
<td colspan=2> <br> </td>
</tr>

</form>
</table>

