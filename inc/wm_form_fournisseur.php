<?php

if(isset($_GET['error_nt'])) { $error_nt=$_GET['error_nt']; } else { $error_nt=''; }
if(isset($_GET['error_m1'])) { $error_m1=$_GET['error_m1']; } else { $error_m1=''; }
if(isset($_GET['error_m2'])) { $error_m2=$_GET['error_m2']; } else { $error_m2=''; }
?>

<table width=100% cellpadding=0 align=center border=0 class=style_form_1>

<form method=post action=wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client=<?php  echo $id_client; ?>>

<tr>
<td>
<?php
echo f_affiche_bouton_submit ('modifier_fournisseur', 'Enregistrer', 1, '');
echo f_affiche_bouton_submit ('supprimer_client', 'Supprimer', 2, '');
echo f_affiche_bouton_submit ('commandes_fournisseur', 'Commandes', 2, 'wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client='.$id_client.'&tab_com_tier=C');
echo f_affiche_bouton_submit ('tab_produit', 'Stats Produits', 2, 'wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client='.$id_client.'&tab_produit=Y');

if ($flag_gestion_produit == 'O') {
echo f_affiche_bouton_submit ('form_produit', 'Produits', 2, 'wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client='.$id_client.'&form_produit=Y');
} 

?>
<br> <br>
</td>
<td>
<?php  if ($error_ > 0) { 
 f_affiche_texte_n_sec (10000, 'Problème : cf formulaire','nok');
 }
 else if ($error_ == 0 and isset($_POST['modifier_fournisseur'])){ 
 f_affiche_texte_n_sec (5000, 'Modification effectu&eacute;e','ok');
 }
 ?>
</td>
</tr>

<tr>
<?php 
if ( $nom_tiers == '' ) { ?> 
<td colspan=2 class=titre2 bgcolor=<?php  echo $color_title; ?> align=left> CREATION NOUVEAU FOURNISSEUR </td>
<?php  
}
else { ?>
<td colspan=2 class=titre2 bgcolor=<?php  echo $color_title; ?> align=left> FOURNISSEUR : <?php  echo $nom_tiers; ?> 
<span class=style_form_1> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php  echo $date_insertion; ?> </span>
</td>
<?php  } ?>
</tr>

<tr>
<td colspan=2> <br> </td>
</tr>

<tr>
<td width=70%>
<!-- FORMULAIRE ----------------------------------->
<table border=0 width=100%>

<tr>
<td width=15% bgcolor=<?php  echo $color_title; ?> align=right> Id Fournisseur &nbsp;&nbsp;</td>
<td width=30%> <input type=text class=style_form_1 name=num_client disabled=disabled size=45 value="<?php  echo $id_client; ?>"> </td>
<td width=30%> <?php echo $date_modification; ?> </td>
<td width=25%></td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Nom &nbsp;&nbsp;</td>
<td colspan=3> 
<?php  if ($nom_tiers != 'pb') { ?>
<input type=text class=style_form_1 name=nom_tiers size=45 value="<?php  echo $nom_tiers; ?>">
<?php  } 
else { ?>
<input type=text class=style_form_2 name=nom_tiers size=45 value="A RENSEIGNER">
<?php  } ?>
</td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Region &nbsp;&nbsp;</td>
<td colspan=3> <select input type=text class=style_form_1 name=categorie style='width: 250px; height: 20px;'> 
<option> <?php echo $categorie; ?> </option>
<option> Alsace </option>
<option> Autre </option>
<option> Bordeaux </option>
<option> Bourgogne </option>
<option> Champagne </option>
<option> Etranger </option>
<option> Jura </option>
<option> Languedoc </option>
<option> Provence </option>
<option> Savoie </option>
<option> Sud-Ouest </option> 
<option> Vallée du Rhone </option> </select> </td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> SIRET &nbsp;&nbsp;</td>
<td colspan=3> <input type=text class=style_form_1 name=num_siret size=45 value="<?php  echo $num_siret; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> TVA &nbsp;&nbsp;</td>
<td colspan=3> <input type=text class=style_form_1 name=num_tva size=45 value="<?php  echo $num_tva; ?>"> </td>
</tr>

<tr>
<td colspan=4> <br> </td>
</tr>

<tr>
<td> <br> </td>
<td bgcolor=<?php  echo $color_title; ?> align=center align=right> Adresse &nbsp;&nbsp;</td>
<td> <br> </td>
<td bgcolor=<?php  echo $color_title; ?> align=center align=right> Gestion Produit &nbsp;&nbsp;
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Rue &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=adr_livraison_1 size=45 value="<?php  echo $adr_livraison_1; ?>"> </td>
<td> <br> </td>
<td> 
<input type=radio class=style_form_1 name=flag_gestion_produit value='N' <?php  if ($flag_gestion_produit == 'N') { echo 'checked'; } ?>> Non
<input type=radio class=style_form_1 name=flag_gestion_produit value='O' <?php  if ($flag_gestion_produit == 'O') { echo 'checked'; } ?>> Oui

</td>



</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?>> <br> </td>
<td> <input type=text class=style_form_1 name=adr_livraison_2 size=45 value="<?php  echo $adr_livraison_2; ?>"> </td>
<td colspan=2> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> CP &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=adr_livraison_cp size=45 value="<?php  echo $adr_livraison_cp; ?>"> </td>
<td colspan=2> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Ville &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=adr_livraison_ville size=45 value="<?php  echo $adr_livraison_ville; ?>"> </td>
<td colspan=2> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Tel &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=telephone_fixe size=45 value="<?php  echo $telephone_fixe; ?>"> </td>
<td colspan=2> <br> </td>
</tr>

<tr>
<td colspan=4> <br> </td>
</tr>

<tr>
<td> <br> </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> Nom Pr&eacute;nom </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> Mail </td>
<td bgcolor=<?php  echo $color_title; ?> align=center> Envoi commande PDF </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Contact comptable &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=nom_contact_1 size=45 value="<?php  echo $nom_contact_1; ?>"> </td>
<td> 
<?php  if ( $mail_contact_1 != 'pb' ) { ?>
<input type=text class=style_form_1 name=mail_contact_1 size=45 value="<?php  echo $mail_contact_1; ?>">
<?php  
}
   else { ?>
<input type=text class=style_form_2 name=mail_contact_1 size=45 value="<?php  echo $mail_contact_1; ?>">
<?php  } ?>
</td>
<td align=center> 
<input type=radio class=style_form_1 name=flag_envoi_pdf value='N' <?php  if ($flag_envoi_pdf == 'N') { echo 'checked'; } ?>> Non
<input type=radio class=style_form_1 name=flag_envoi_pdf value='O' <?php  if ($flag_envoi_pdf == 'O') { echo 'checked'; } ?>> Oui
 </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Contact commission &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=nom_contact_2 size=45 value="<?php  echo $nom_contact_2; ?>"> </td>
<td> 
<?php  if ( $mail_contact_2 != 'pb' ) { ?>
<input type=text class=style_form_1 name=mail_contact_2 size=45 value="<?php  echo $mail_contact_2; ?>">
<?php  
}
   else { ?>
<input type=text class=style_form_2 name=mail_contact_2 size=45 value="<?php  echo $mail_contact_2; ?>">
<?php  } ?>
</td>
<td> <br> </td>
</tr>

<tr>
<td colspan=4> <br> </td>
</tr>

<tr>
<td colspan=4 bgcolor=<?php  echo $color_title; ?> align=left height=20> &nbsp;&nbsp; Commentaire </td>
</tr>

<tr>
<td colspan=4> <textarea class=style_form_1 name=commentaire rows=10 cols=180><?php echo $commentaire; ?></textarea> </td>
</tr>

</table>
<!-- FIN DU FORMULAIRE ---------------------------->
</td>
<td valign=top>

<!-- STATS ---------------------------------------->
<table width=100%>
<tr><td>
<table class=style_form_1 width=60% align=right>
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
<table class=style_form_1 width=60% align=right>
<tr><td class=style_form_3 align=center colspan=2 bgcolor=<?php  echo $color_title; ?>> TOP <?php $n=3; echo $n; ?> </td>
<tr> <td> <?php  f_affiche_top_client_fournisseurs ($login, $id_client, 'F', $n, $v_annee); ?> </td> </tr>
</table>
</td></tr>
</table>
<!-- FIN STATS ------------------------------------>


</td>
</tr>



</form>





</table>

