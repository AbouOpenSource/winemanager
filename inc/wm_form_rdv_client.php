
<form method=post action=wm_accueil.php?menu_=n_a&tiers_=client&id_client=<?php echo $id_client; ?>&tab_rdv_tier=Y&num_rdv=<?php echo $num_rdv; ?>>

<table width=95% cellpadding=0 align=center border=0 class=style_form_1>

<!-- FORMULAIRE RDV ---------------------------------------------------------------------------------------->
<tr>
<td align=left colspan=4> 
<?php  
echo f_affiche_bouton_submit ('ajouter_rdv', 'Nouveau', 2, ''); 
echo f_affiche_bouton_submit ('modifier_rdv', 'Enregistrer', 2, ''); 
echo f_affiche_bouton_submit ('supprimer_rdv', 'Supprimer', 2, ''); 
echo '<br><br>';
?>
</td>
</tr>

<tr>
<td align=right height=23 colspan=4 bgcolor=<?php  echo $color_title; ?> class=style_form_1> 
<?php  
echo  'Prochain RDV : ' . f_retourne_prochain_rdv_client($login, $id_client) . '&nbsp;&nbsp;';
?>
</td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> N&deg; RDV &nbsp;&nbsp;</td>
<td colspan=3> <input disabled=disabled type=text class=style_form_1 name=num_rdv_display size=12 value="<?php  echo $num_rdv; ?>">
     <input type=hidden class=style_form_1 name=num_rdv size=15 value="<?php  echo $num_rdv; ?>">
</td> 
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right width=25%> Date du RDV &nbsp;&nbsp;</td>
<td width=15%> <input type=text class=style_form_1 name=date_rdv  size=13 value="<?php  echo $date_rdv; ?>" title="Format de date jj/mm/aaaa"> </td>
<td bgcolor=<?php  echo $color_title; ?> align=right width=25%> Heure du RDV &nbsp;&nbsp;</td>
<td width=35%> <input type=text class=style_form_1  name=heure_rdv size=13 value="<?php  echo $heure_rdv; ?>"> </td>
</tr>

<tr>
<td bgcolor=<?php  echo $color_title; ?> align=right> Sujet &nbsp;&nbsp;</td>
<td colspan=3> <input type=text class=style_form_1 name=sujet size=73 value="<?php  echo $sujet; ?>"> </td> 
</tr>

<tr>
<td valign=top bgcolor=<?php  echo $color_title; ?> align=right> <br> Objectifs &nbsp;&nbsp;</td>
<td colspan=3> <textarea class=style_form_1 name=objectif rows=20 cols=70><?php  echo $objectif; ?></textarea> </td>
</tr>

</table>

</form>


