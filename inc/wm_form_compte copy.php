
<?php
$pied_de_page = "
Si ce champ n'est pas renseigné, voici l'affichage :
---------------------------------------------------------------
Société
NOM Prénom
Adresse
Tel fixe : XXXXXXXXXX
Tel Mobile : XXXXXXXXXX

www.winemanager.fr
";

?>

<table width=100% cellpadding=0 align=center border=0 class=style_form_1>

<form method=post action=wm_accueil.php?info_=compte>

<tr>
<td colspan=4>
<?php 
echo f_affiche_bouton_submit ('modifier_compte', 'Enregistrer', 1, '');
echo f_affiche_bouton_submit ('modifier_mdp', 'Modifier mdp', 2, '');
echo "<span onClick=document.location='docs/WM_documentation_site.pdf'; style=cursor:pointer> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Documentation site </span>";

?>
<br> <br>
</td>
<td>
<?php  if ($error_ > 0) { 
 f_affiche_texte_n_sec (10000, $msg_a_afficher, 'nok');
 }
 else if ($error_ == 0 and (isset($_POST['modifier_compte']) or isset($_POST['modifier_mdp']))){ 
 f_affiche_texte_n_sec (5000, $msg_a_afficher, 'ok');
 }
 ?>
</td>
</tr>

<tr>
<td colspan=5 class=titre2 bgcolor=<?php  echo $color_title; ?> align=left> COMPTE : <?php  echo $v_login; ?> 
<span class=style_form_1> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php  echo $v_dat_cre; ?> </span>
</td>
</tr>

<tr>
<td colspan=5> <br> </td>
</tr>

<tr>
<td width=10% bgcolor=<?php  echo $color_title; ?> align=right> Société &nbsp;</td>
<td width=25%> <input type=text class=style_form_1 name=nom_tiers size=50 value="<?php  echo $v_nom_tiers; ?>"> </td>
<td width=5%> </td>
<td width=10% bgcolor=<?php  echo $color_title; ?> align=right> SIRET &nbsp;</td>
<td> <input type=text class=style_form_1 name=num_siret size=50 value="<?php  echo $v_num_siret; ?>"> </td>
</tr>
<tr>
<td>  </td>
<td>  </td>
<td> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> TVA &nbsp;</td>
<td> <input type=text class=style_form_1 name=num_tva size=50 value="<?php  echo $v_num_tva; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Nom &nbsp;</td>
<td> <input type=text class=style_form_1 name=nom size=50 value="<?php  echo $v_nom; ?>"> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Prénom &nbsp;</td>
<td> <input type=text class=style_form_1 name=prenom size=50 value="<?php  echo $v_prenom; ?>"> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Adresse &nbsp;</td>
<td> <input type=text class=style_form_1 name=adresse1 size=50 value="<?php  echo $v_adresse1; ?>"> </td>
<td> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> Mail &nbsp;</td>
<td> <input type=text class=style_form_1 name=e_mail size=50 value="<?php  echo $v_e_mail; ?>"> </td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right>   </td>
<td> <input type=text class=style_form_1 name=adresse2 size=50 value="<?php  echo $v_adresse2; ?>"> </td>
<td> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> Tel Fixe &nbsp;</td>
<td> <input type=text class=style_form_1 name=tel_fixe size=50 value="<?php  echo $v_tel_fixe; ?>"> </td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> CP &nbsp;</td>
<td> <input type=text class=style_form_1 name=cp size=50 value="<?php  echo $v_cp; ?>"> </td>
<td> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> Tel Mobile &nbsp;</td>
<td> <input type=text class=style_form_1 name=tel_mobile size=50 value="<?php  echo $v_tel_mobile; ?>"> </td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Ville &nbsp;</td>
<td> <input type=text class=style_form_1 name=ville size=50 value="<?php  echo $v_ville; ?>"> </td>
<td> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right> Nb lignes commande &nbsp;</td>
<td> <input type=text class=style_form_1 name=nb_lignes_commande size=5 value="<?php  echo $v_nb_lignes_commande; ?>" title="Maximum 100 lignes"></td>
</tr>

<tr>
<td colspan=5> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right height=20 valign=top> &nbsp;&nbsp; Pied de mail &nbsp;</td>
<td colspan=4> <textarea class=style_form_1 name=pied_de_mail rows=10 cols=150 title="<?php echo $pied_de_page; ?>"><?php echo $v_pied_de_mail; ?></textarea> </td>
</tr>

</tr>
<td colspan=5> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Date création &nbsp;</td>
<td> <?php  echo $v_dat_cre; ?> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Date modification &nbsp;</td>
<td> <?php  echo $v_dat_upd; ?> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Date Début forfait &nbsp;</td>
<td> <?php  echo $v_dat_deb; ?> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Date Fin Forfait &nbsp;</td>
<td> <?php  echo $v_dat_fin; ?> </td>
<td> </td>
<td> </td>
<td> </td>
</tr>

</tr>
<td colspan=5> <br> </td>
</tr>

</tr>
<td class=titre2 colspan=5 bgcolor=<?php  echo $color_title; ?>> Changer de mot de passe </td>
</tr>
</tr>
<td colspan=5> <br> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Actuel &nbsp;</td>
<td> <input type=password class=style_form_1 name=mdp1 size=50 > </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Nouveau &nbsp;</td>
<td> <input type=password class=style_form_1 name=mdp2 size=50 > </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Confirmation &nbsp;</td>
<td> <input type=password class=style_form_1 name=mdp3 size=50 > </td>
<td> </td>
<td> </td>
<td> </td>
</tr>
</tr>
<td colspan=5> <br> </td>
</tr>

</form>
</table>