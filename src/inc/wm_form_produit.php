

<form method=post action=wm_accueil.php?menu_=n_a&tiers_=fournisseurs&id_client=<?php  echo $id_client; ?>&form_produit=Y>

<table width=100% cellpadding=0 align=center border=1 class=style_form_1>

<!-- FORMULAIRE PRODUIT ---------------------------------------------------------------------------------------->
<tr>
<td align=left colspan=2> 
<?php  
echo f_affiche_bouton_submit ('ajouter_produit', 'Nouveau', 2, ''); 
echo f_affiche_bouton_submit ('modifier_produit', 'Enregistrer', 2, ''); 
echo f_affiche_bouton_submit ('supprimer_produit', 'Supprimer', 2, ''); 
echo '<br><br>';
?>
</td>
</tr>


<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> N&deg; Produit &nbsp;&nbsp;</td>
<td> <input disabled=disabled type=text class=style_form_1 name=num_produit size=12 value="<?php  echo $num_produit; ?>">
     <input type=hidden class=style_form_1 name=num_produit size=15 value="<?php  echo $num_produit; ?>">
</td> 
</tr>


<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Nom &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=nom_produit size=80 value="<?php  echo $nom_produit; ?>"> </td> 
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Contenant &nbsp;&nbsp;</td>
<td> 
<select input type=text class=style_form_1 name=contenant style='width: 250px; height: 20px;' value="<?php  echo $contenant; ?>"> 
<option> <?php echo $contenant; ?> </option>
<option> DEMI-BOUTEILLE </option>
<option> BOUTEILLE </option>
<option> MAGNUM </option>
<option> JEROBOAM </option></select>
</td> 
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Millesime &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=millesime size=10 value="<?php  echo $millesime; ?>"> </td> 
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Couleur / Robe &nbsp;&nbsp;</td>
<td> 
<select input type=text class=style_form_1 name=couleur style='width: 250px; height: 20px;' value="<?php  echo $couleur; ?>"> 
<option> <?php echo $couleur; ?> </option>
<option> BLANC </option>
<option> JAUNE </option>
<option> ROUGE </option>
<option> ROSE </option></select>
</td> 
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Prix &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=prix size=10 value="<?php  echo $prix; ?>"> </td> 
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Commission &nbsp;&nbsp;</td>
<td> <input type=text class=style_form_1 name=commission size=10 value="<?php  echo $commission; ?>"> </td> 
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Visible &nbsp;&nbsp;</td>
<td> 
<input type=radio class=style_form_1 name=flag_produit_visible value='N' <?php  if ($flag_produit_visible == 'N') { echo 'checked'; } ?>> Non
<input type=radio class=style_form_1 name=flag_produit_visible value='O' <?php  if ($flag_produit_visible == 'O') { echo 'checked'; } ?>> Oui
</td> 
</tr>




<tr>
<td valign=top bgcolor=<?php  echo $color_title; ?> align=right> <br> Commission &nbsp;&nbsp;</td>
<td> <textarea class=style_form_1 name=objectif rows=5 cols=30><?php  echo $objectif; ?></textarea> </td>
</tr>

</table>

</form>

