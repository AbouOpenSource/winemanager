
<table width=100% cellpadding=0 align=center border=0 class=style_form_1>

<?php if ($type_commande == 'C') { ?>
<form method=post action=wm_accueil.php?menu_=n_a&action_=commande&num_commande=<?php  echo $num_commande; ?>>
<?php } ?>

<?php if ($type_commande == 'D') { ?>
<form method=post action=wm_accueil.php?menu_=n_a&action_=devis&num_commande=<?php  echo $num_commande; ?>>
<?php } ?>

<!-- AFFICHAGE DES BOUTONS -->
<tr>
<td colspan=3>
<?php
$etat_commande		= f_calcul_etat_commande ($num_commande, $login);
$statut_commande	= f_test_commande_ok($login, $num_commande);
$date_envoi_client	= f_calcul_date_envoi_commande($num_commande, $login);

//--------------------------------------------------------------------------------------------------------------------

if ($type_commande == 'C') {
	echo f_affiche_bouton_submit ('modifier_commande', 'Enregistrer', 1, '');
	echo f_affiche_bouton_submit ('supprimer_commande', 'Supprimer', 2, '');
	echo f_affiche_bouton_submit ('epurer_commande', 'Epurer', 2, '');
	echo f_affiche_bouton_submit ('envoyer_commande', 'Envoyer', 2, '');
	//echo f_affiche_bouton_submit ('pdf_commande', 'PDF', 2, '');
} 

if ($type_commande == 'D') {
	echo f_affiche_bouton_submit ('modifier_commande', 'Enregistrer', 1, '');
	echo f_affiche_bouton_submit ('supprimer_commande', 'Supprimer', 2, '');
	echo f_affiche_bouton_submit ('valider_devis', 'Valider', 2, '');
} 

?>

<br><br>
</td>

<!-- AFFICHAGE DU TEXTE X MS --> 
<td>
<?php  

if (isset($_POST['modifier_commande'])){ 
 f_affiche_texte_n_sec (5000, 'Modification effectu&eacute;e', 'ok');
 }
 
else if (isset($_POST['envoyer_commande'])) {
  f_affiche_texte_n_sec (5000, 'Commande envoy&eacute;e au client', 'ok');
}

else if ($num_plv_ > 0) {
	if ($error_ == 0) {
		f_affiche_texte_n_sec (5000, 'Commande envoy&eacute;e au fournisseur', 'ok');
	}
	else {
		f_affiche_texte_n_sec (5000, 'Mail non envoy&eacute au fournisseur', 'nok');
	}
	
}

 ?>
</td>
</tr>

<!-- TITRE DU FORMULAIRE -->

<tr valign=center>
<td colspan=3 class=titre2 bgcolor=<?php  echo $color_title; ?> align=left> 


<?php if ($type_commande == 'C') { ?> Commande N° <?php } ?>

<?php if ($type_commande == 'D') { ?> Devis N° <?php } ?>

<?php 
echo $num_commande; 
if ($date_envoi_client != '0000-00-00 00:00:00') {
	echo '&nbsp &nbsp &nbsp &nbsp &nbsp <span class=style_form_1>La commande a été envoyée le ' . NormalDate_heure($date_envoi_client) . '</span>';
}
?>
</td>
<td class=titre2 bgcolor=<?php  echo $color_title; ?> align=right>
<?php
$total_commande = f_calcul_montant_ht_commande($num_commande, $login);
if( $total_commande > 0) { echo 'Total HT : ' . $total_commande . ' &euro;'; }
?>
</td>

</tr>

<!-- FORMULAIRE -->

<tr>
<td colspan=4> <br> </td>
</tr>

<tr>
<td width=15% bgcolor=<?php  echo $color_title; ?>> N° Commande </td>
<td width=35% > <input type=text class=style_form_1 name=num_commande size=20 disabled=disabled value="<?php  echo $num_commande; ?>"> <?php echo $date_modification; ?> </td>
<td width=15% bgcolor=<?php  echo $color_title; ?>> Date de livraison  </td>
<td width=35% > <input type=text class=style_form_1 name=livraison_date size=10 value="<?php  echo $livraison_date; ?>" title="Format de date jj/mm/aaaa" /> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?>> Client </td>
<td> 

<?php 
echo "<select input type=text class=style_form_1 name=nom_client size=1 style='width: 450px; height: 20px;'>";
if ($nom_client =='') {
$premiere_ligne='&nbsp;&nbsp;&nbsp;';
}
else {
$premiere_ligne=$nom_client;
}
f_form_affiche_liste_clients_fournisseurs($login, 'C', $premiere_ligne);
echo '</select>';
?>

</td>
<td bgcolor=<?php  echo $color_title; ?>> Heure de début  </td>
<td> <input type=text class=style_form_1 name=livraison_h_debut size=10 value="<?php  echo $livraison_h_debut; ?>"> </td>

</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?>> Date </td>
<td> <input type=text class=style_form_1 name=commande_date size=15 value="<?php  echo $commande_date; ?>" title="Format de date jj/mm/aaaa" /> &nbsp;
<?php echo $date_insertion; ?>
</td>
<td bgcolor=<?php  echo $color_title; ?>> Heure de fin  </td>
<td> <input type=text class=style_form_1 name=livraison_h_fin size=10 value="<?php  echo $livraison_h_fin; ?>"> </td>
</tr>

<tr>

<td bgcolor=<?php  echo $color_title; ?>> Type </td>
<td>
<input type=radio class=style_form_1 name=type_commande value=C <?php  if ($type_commande == 'C') { echo 'checked'; } ?> > Commande
<input type=radio class=style_form_1 name=type_commande value=D <?php  if ($type_commande == 'D') { echo 'checked'; } ?>> Devis
</td>
<td bgcolor=<?php  echo $color_title; ?>> Commentaire  </td>
<td> <input type=text class=style_form_1 name=commentaire size=45 value="<?php  echo $commentaire; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?>> Statut </td>
<td> <select input type=text class=style_form_1 name=etat_commande  style='width: 150px; height: 20px;'> 

<?php if ($type_commande == 'C') { ?>
<option> <?php echo $v_etat_commande; ?> </option>
<option> En cours </option>
<option> Terminée </option>
<option> Annulée </option> </select>
<?php } ?>

<?php if ($type_commande == 'D') { ?>
<option> <?php echo $v_etat_commande; ?> </option>
<option> En cours </option>
<option> Annulée </option> </select>
<?php } ?>

</td>

<td bgcolor=<?php  echo $color_title; ?>> Saisir Adr. Livraison </td>
<td>
<input type=radio class=style_form_1 name=adr_livraison_flag value=N <?php  if ($adr_livraison_flag == 'N') { echo 'checked'; } ?>> Non
<input type=radio class=style_form_1 name=adr_livraison_flag value=O <?php  if ($adr_livraison_flag == 'O') { echo 'checked'; } ?>> Oui
</td>

</tr>

<?php // Affichage du champs adresse de livraison de la commande
if ($adr_livraison_flag == 'O') {
?>
<tr>
<td colspan=3> <br> </td>
<td> <textarea class=style_form_1 name=adr_livraison rows=4 cols=45 title="Ce champs est à renseigner si l'adresse de livraison du client est différente de celle de la fiche cliente."> <?php echo $adr_livraison; ?> </textarea> </td>
</tr>
<?php
}
?>

<tr>
<td colspan=4> 
<?php

if (f_calcul_nb_plv_commande($num_commande, $login) > 0 and $type_commande == 'C') {
 f_affiche_plv($login, $num_commande, $color_title);
}

else { echo '<br>'; }

?>
</td>
</tr>

<tr>
<td colspan=4> <br> </td>
</tr>



<!-- AFFICHAGE DU TABLEAU DES COMMANDES -------------------------------------------->
<tr>
<td colspan=4>

<!-- AFFICHAGE DE L'ENTETE -->

<?php  f_form_affiche_lignes_commandes ($login, $__NB_LIGNES_FORMULAIRES_COMMANDE, $num_commande, $color_title); ?>

<!-- AFFICHAGE DU DETAIL -->



</td>
</tr>


<!-- FIN DU FORMULAIRE ---------------------------->


<tr>
<td colspan=4> <br> </td>
</tr>

</form>
</table>