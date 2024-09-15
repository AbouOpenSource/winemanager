<table width=25% cellpadding=0 align=center border=0 class=style_form_1>
<tr><td align=center class=style18> <hr> </td></tr>
<tr>
<td align=center class=style1 > CONTACT </td>
</tr>
</table>

<table width=45% cellpadding=2 align=center border=0 class=style_form_1>
<form method=post action=index.php>

<tr>
<td colspan=2 align=center class=style_form_1> <br> Merci de laisser vos coordonn&eacute;es afin que nous puissions vous contacter. <br><br> </td>
</tr>

<tr>
<td bgcolor=#B3B3B3 align=right>Nom Pr&eacute;nom </td>
<td><input type=text class=style_form_1 name=nom_prenom_ value="<?php echo $nom_prenom_; ?>" size=65></td>
</tr>
<tr>
<td bgcolor=#B3B3B3 align=right>Email </td>
<td><input type=text class=style_form_1 name=e_mail_ value="<?php echo $e_mail_; ?>" size=65></td>
</tr>
<tr>
<td bgcolor=#B3B3B3 align=right>Mobile </td>
<td><input type=text class=style_form_1 name=mobile_ value="<?php echo $mobile_; ?>" size=65></td>
</tr>
<tr>
<td bgcolor=#B3B3B3 align=right valign=top>Message </td>
<td><textarea class=style_form_1 name=message_ rows=15 cols=65><?php echo $message_; ?></textarea></td>
</tr>
<tr>
<td colspan=2 align=center>
<br>
<input type=submit value=Envoyer name=envoyer_ class=menu2 style='background:#FFF6FD; border: 1px solid #B3B3B3; cursor: pointer; width:100px'>
</td>
</tr>
</form>

</table>
