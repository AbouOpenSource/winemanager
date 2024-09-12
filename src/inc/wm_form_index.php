<?php

// DECLARATION DES VARIABLES --------------------------------------------------------------------------------------------------------------
$error_=0;
$msg_ = '';
$vue_formulaire_contact=0;
$year_deb=2014;
$Actual_year=date('Y');
if ( $year_deb == $Actual_year ) { 
	$copyr='TBI &copy Copyright ' . $year_deb;
}
else {
	$copyr='TBI &copy Copyright ' . $year_deb .' - ' . $Actual_year; 
}

// GESTION DE L'ENVOI DU MESSAGE ----------------------------------------------------------------------------------------------------------
if (isset($_POST['envoyer_'])) {
 
 $nom_prenom_	= trim($_POST['nom_prenom_']);
 $e_mail_		= trim($_POST['e_mail_']);
 $mobile_		= trim($_POST['mobile_']);
 $message_		= trim($_POST['message_']);
 
 $nom_prenom_	= addslashes($nom_prenom_);
 $e_mail_		= addslashes($e_mail_);
 $mobile_		= addslashes($mobile_);
 $message_		= addslashes($message_);
 
 if (f_verifie_mail($e_mail_) == 1 or $e_mail_ == 'A ressaisir')	{ $e_mail_ = 'A ressaisir'; $error_= $error_ + 1; }
 if ($nom_prenom_ == '' or $nom_prenom_ == 'A renseigner')			{ $nom_prenom_ = 'A renseigner'; $error_= $error_ + 1; }
 if ($mobile_ == '' or $mobile_ == 'A renseigner')					{ $mobile_ = 'A renseigner'; $error_= $error_ + 1; }
 if ($message_ == '' or $message_ == 'A renseigner')				{ $message_ = 'A renseigner'; $error_= $error_ + 1; }
 
 // ENVOI DU MAIL
 if ($error_ == 0) {
	$id_=f_envoi_mail_contact ($e_mail_ , $nom_prenom_ , $mobile_ , $message_);
	if ($id_ == 0) { $msg_="Votre message a bien &eacute;t&eacute; envoy&eacute;."; }
	else { $msg_="Un probl&egrave;me est survenu, merci de recommencer."; }
 }
 else {
	$msg_ = 'Merci de ressaisir les informations.';
	$vue_formulaire_contact=1;
 }
 
}
else {
 $nom_prenom_	= '';
 $e_mail_		= '';
 $mobile_		= '';
 $message_		= '';
}
// FIN DE GESTION DE L'ENVOI DU MESSAGE ---------------------------------------------------------------------------------------------------

echo '<br>';

// AFFICHAGE DU FORMULAIRE DE CONTACT --------------------------------------------------------------------------------------------------
if (isset($_POST['contact_']) or $vue_formulaire_contact==1) {
	include('inc/wm_form_contact.php');
}
// AFFICHAGE DU MESSAGE ---------------------------------------------------------------------------------------------------------------
else {

	// AFFICHAGE DU FORMULAIRE DE CONNEXION -----------------------------------------------------------------------------------------------
	echo '<table width=25% cellpadding=3 align=center border=0>';
	echo '<tr><td colspan=2 align=center class=style18> <hr> </td></tr>';
	echo '<tr><td colspan=2 align=center class=style1> WINE MANAGER </td></tr>';
	echo "<form method=post action='wm_accueil.php?menu_=debut'>";
	echo '<tr>';
	echo '<td class=menu2 width=50% align=right bgcolor=#B3B3B3> Compte </td>';
	echo '<td width=50%> <input type=text name=login size=20 class=menu2> </td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td class=menu2 width=50% align=right bgcolor=#B3B3B3> Mot de passe </td>';
	echo '<td width=50%> <input type=password name=passwd size=20 class=menu2> </td>';
	echo '</tr>';
	echo '<tr><td colspan=2 align=center>'. f_affiche_bouton_submit ('connecter', 'Connexion', 0, '') .'</td></tr>';
	echo '<tr><td colspan=2 align=center class=style18>';
	echo "<span onClick=document.location='wm_accueil.php?a_faire=mdp_oublie'; style=cursor:pointer> Mot de passe oubli&eacute; ? </span>";
	echo '</td></tr>';
	echo '<tr><td colspan=2 align=center class=style18> <hr> ';
	echo '</td></tr>';
	echo '</form>';
	echo '</table>';
	// FIN AFFICHAGE DU FORMULAIRE DE CONNEXION -------------------------------------------------------------------------------------------
	
	// AFFICHAGE DE LA PRESENTATION DU SITE -----------------------------------------------------------------------------------------------
	echo '<table width=50% cellpadding=0 align=center border=0>';
	echo '<tr>';
	echo '<td valign=top align=left class=style7>';
	echo "
	Wine Manager est une application d&eacute;di&eacute;e &agrave; la gestion de l&#146;activit&eacute; d&#146;un agent commercial dans le secteur des Vins et Spiritueux.
	<br><br>
	Ainsi Wine Manager permet de g&eacute;rer toutes les &eacute;tapes de la vente : devis, commandes, gestion de vos clients, gestion de vos
	fournisseurs.
	<br><br>
	Avec Wine Manager, votre gestion de la Relation Client est simplifi&eacute;e : <br>
	- L&#146;ensemble de vos clients et fournisseurs sont consultables en un endroit unique,  <br>
	- Vos devis se transforment en commande en un seul clic, <br>
	- Tout le processus d&#146;envoi de la commande &agrave; vos clients et &agrave; vos fournisseurs est automatis&eacute;, <br>
	- Des statistiques sur l&#146;activit&eacute; cliente et fournisseur sont disponibles en temps r&eacute;el et au fur et &agrave; mesure des commandes saisies. <br>
	<br> 
	Pour plus d&#146;informations, contactez-nous en cliquant sur le bouton ci-dessous.";
	echo '</td>';
	echo '</tr>';
	echo '<tr>';
	echo '<td valign=top align=center>';
	echo "<form method=post action=index.php>";
	echo '<tr><td colspan=2 align=center>';
	if ($msg_ != '') {
		echo '<br> <span class=logo_03>' . $msg_ . '</span><br><br>';
	}
	else { echo '<br><br>';}
	echo f_affiche_bouton_submit ('contact_', 'Contact', 0, '') ;
	echo '</td></tr>';
	// FIN AFFICHAGE DE LA PRESENTATION DU SITE -------------------------------------------------------------------------------------------
		
	echo '</form>';
	echo '</td>';
	echo '</tr>';
	echo '</table>';
}


// AFFICHAGE DE LA BARRE POUR SITE TBI ----------------------------------------------------------------------------------------------------
echo '<table width=25% cellpadding=3 align=center border=0>';
echo '<tr><td colspan=2 align=center class=style18> <hr> ';
echo "<span onClick=document.location='http://tocut.bi.free.fr'; style=cursor:pointer> $copyr </span>";
echo '</td></tr>';
echo '</table>';
// FIN AFFICHAGE DE LA BARRE POUR SITE TBI ------------------------------------------------------------------------------------------------

?>