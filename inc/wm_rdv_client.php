<?php

if(isset($_GET['num_rdv'])) { $num_rdv=$_GET['num_rdv']; } else { $num_rdv=f_retourne_dernier_rdv_client($id_client, $login); }
// Si $num_rdv = 0 --> pas de rdv pour ce client

// Suppression d'un nouveau RDV
if (isset($_POST['supprimer_rdv'])) {
	f_supprime_rdv($login, $id_client, $num_rdv);
	$num_rdv=0;
}

if ($num_rdv == 0) {
	$date_rdv			= '';
	$date_rdv_suivant	= '';
	$sujet				= '';
	$objectif			= '';
	$heure_rdv_suivant	= '';
	$heure_rdv			= '';
}

// Creation d'un nouveau RDV
if (isset($_POST['ajouter_rdv'])) {
	$num_rdv = f_ajoute_rdv ($login, $id_client);
	$date_rdv			= '';
	$date_rdv_suivant	= '';
	$sujet				= '';
	$objectif			= '';
	$heure_rdv_suivant	= '';
	$heure_rdv			= '';
}

// Modification d'un RDV
if (isset($_POST['modifier_rdv'])) {

	$tab_rdv_mod['date_rdv']			= mysqlDate($_POST['date_rdv']);
	$tab_rdv_mod['date_rdv_suivant']	= mysqlDate($_POST['date_rdv_suivant']);
	$tab_rdv_mod['sujet']				= addslashes($_POST['sujet']);
	$tab_rdv_mod['objectif']			= addslashes($_POST['objectif']);
	$tab_rdv_mod['heure_rdv_suivant']	= addslashes($_POST['heure_rdv_suivant']);
	$tab_rdv_mod['heure_rdv']			= addslashes($_POST['heure_rdv']);
	
	f_modification_rdv($login, $id_client, $num_rdv, $tab_rdv_mod);
}

$tab_rdv_mod = f_affiche_form_rdv_client ($id_client, $login, $num_rdv);

$date_rdv			= NormalDate($tab_rdv_mod['date_rdv']);
$date_rdv_suivant	= NormalDate($tab_rdv_mod['date_rdv_suivant']);
$sujet				= $tab_rdv_mod['sujet'];
$objectif			= $tab_rdv_mod['objectif'];
$heure_rdv_suivant	= $tab_rdv_mod['heure_rdv_suivant'];
$heure_rdv			= $tab_rdv_mod['heure_rdv'];

if ($date_rdv == '//' or $date_rdv == '00/00/0000') { $date_rdv = ''; }
if ($date_rdv_suivant == '//' or $date_rdv_suivant == '00/00/0000') { $date_rdv_suivant = ''; }

?>

<table width=100% cellpadding=0 align=center border=0 class=style_form_1>

<!-- Affichage du titre -->
<tr>
<td colspan=2> <br><br> </td>
</tr>
<tr>
<td colspan=2 bgcolor=#B3B3B3 class=titre2> <?php echo f_affiche_nom_client ($id_client, $login); ?> </td>
</tr>
<tr>
<td colspan=2> <br> </td>
</tr>

<tr valign=top>

<!-- Affichage du tableau -->
<td width=50%>
<?php f_affiche_tab_rdv_client ($id_client, $login); ?>
</td>

<!-- Affichage du formulaire -->
<td width=50%>
<?php include('inc/wm_form_rdv_client.php'); ?>
</td>

</tr>

</table>



